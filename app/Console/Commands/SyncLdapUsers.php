<?php

namespace App\Console\Commands;

use App\Ldap\User as AppLdapUser;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\User;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;

class SyncLdapUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Permite pasar un filtro LDAP opcional.
     *
     * @var string
     */
    protected $signature = 'ldap:sync-users
                            {--filter= : A raw LDAP filter to apply to the LDAP query (default: (objectClass=user))}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza (actualiza e inserta) los usuarios LDAP en la tabla users.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Define un filtro predeterminado si no se proporciona uno.
        $filter = $this->option('filter') ?: '(objectClass=user)';
        $this->info("Usando filtro LDAP: $filter");

        // Realiza la consulta a LDAP usando el modelo ActiveDirectory de LDAPRecord.
        $ldapUsers = LdapUser::query()
        ->whereRaw($filter)->get();

        if ($ldapUsers->isEmpty()) {
            $this->info(string: 'No se encontraron usuarios en LDAP para sincronizar.');
            return 0;
        }

        // Contador de usuarios sincronizados
        $syncedCount = 0;

        // Recorre cada usuario LDAP
        foreach ($ldapUsers as $ldapUser) {
            // Obtén el DN (Distinguished Name) que usaremos como identificador único.
            $dn = $ldapUser->getDn();

            // Busca en la base de datos un usuario con este DN; si no existe, crea uno nuevo.
            $localUser = User::firstOrNew(['ldap_dn' => $dn]);

            // Mapea los atributos de LDAP a los campos de la tabla users.
            // Ajusta estos nombres según lo que realmente retorne tu servidor LDAP.
            $localUser->name = $ldapUser->getFirstAttribute('cn')
                                ?? $ldapUser->getFirstAttribute('displayName')
                                ?? 'Sin nombre';
            $localUser->email = $ldapUser->getFirstAttribute('mail')
                                 ?? $ldapUser->getFirstAttribute('userPrincipalName')
                                 ?? Str::slug($localUser->name) . '@example.com';

            // Si es un usuario nuevo, asigna una contraseña aleatoria.
            if (! $localUser->exists) {
                $localUser->password = bcrypt(Str::random(16));
            }

            // Aquí puedes mapear más atributos, por ejemplo:
            // $localUser->username = $ldapUser->getFirstAttribute('sAMAccountName');

            // Guarda o actualiza el registro.
            $localUser->save();
            $syncedCount++;
        }

        $this->info("Se sincronizaron/actualizaron exitosamente [$syncedCount] usuario(s) de LDAP en la tabla users.");
        return 0;
    }
}
