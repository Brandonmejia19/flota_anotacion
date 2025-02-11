<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LdapRecord\Connection;
use LdapRecord\Container;
use App\Models\User as LocalUser;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Importldap extends Command
{
    protected $signature = 'ad:import-users';
    protected $description = 'Import users from Active Directory to local database';

    public function handle()
    {
        $this->info('Iniciando importación de usuarios de Active Directory...');

        try {
            // Verificar configuración
            $config = config('ldap.connections.ad_connection');
            $this->info('Configuración LDAP encontrada: ' . ($config ? 'Sí' : 'No'));

            if (empty($config)) {
                throw new \Exception('La configuración LDAP para ad_connection no se encuentra.');
            }

            // Establecer conexión
            $connection = new Connection($config);
            Container::addConnection($connection, 'ad_connection');
            Container::setDefaultConnection('ad_connection');

            // Verificar conexión
            try {
                $connection->connect();
                $this->info('Conexión LDAP establecida exitosamente');
            } catch (\Exception $e) {
                throw new \Exception('Error al conectar con LDAP: ' . $e->getMessage());
            }

            // Consultar usuarios
            $ldapUserInstance = new LdapUser();
            $ldapUsers = $ldapUserInstance->newQuery()
                ->whereHas('user')
                ->get();

            $this->info('Usuarios encontrados en AD: ' . count($ldapUsers));

            $count = 0;

            foreach ($ldapUsers as $ldapUser) {
                $this->info('Procesando usuario...');

                $samAccountName = $ldapUser->getFirstAttribute('samaccountname');
                $email = $ldapUser->getFirstAttribute('mail');
                $name = $ldapUser->getFirstAttribute('cn');

                $this->info("Datos encontrados:
                    SAMAccountName: $samAccountName
                    Email: $email
                    Name: $name");

                if (!$samAccountName || !$email) {
                    $this->warn("Usuario saltado - falta información requerida");
                    continue;
                }

                try {
                    LocalUser::updateOrCreate(
                        ['email' => $email],
                        [
                            'name' => $name ?? 'Sin nombre',
                            'username' => $samAccountName,
                            'password' => Hash::make('password_default'), // Contraseña temporal
                            'email_verified_at' => now(),
                        ]
                    );

                    $count++;
                    $this->info("Usuario $samAccountName importado exitosamente.");
                } catch (\Exception $e) {
                    $this->error("Error al guardar usuario $samAccountName: " . $e->getMessage());
                    Log::error("Error al importar usuario AD: " . $e->getMessage());
                }
            }

            $this->info("Se importaron o actualizaron $count usuarios.");

        } catch (\Exception $e) {
            $this->error('Ocurrió un error durante la importación: ' . $e->getMessage());
            Log::error('Error en importación AD: ' . $e->getMessage());
            return 1;
        }

        $this->info('Importación de usuarios de Active Directory completada.');
    }
}
