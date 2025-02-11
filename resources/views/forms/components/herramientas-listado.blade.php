<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
<div x-data="{
    // El estado se vincula con el valor del campo (almacenado en la propiedad 'state')
    items: @entangle($getStatePath()).defer
}">
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="border-b">
                <th class="px-2 py-1 text-left">Herramienta</th>
                <th class="px-2 py-1 text-left">Existencia</th>
                <th class="px-2 py-1 text-left">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <template x-for="(item, index) in items" :key="index">
                <tr class="border-b">
                    <!-- Columna de Herramienta: solo de lectura -->
                    <td class="px-2 py-1">
                        <span x-text="item.herramienta"></span>
                    </td>
                    <!-- Columna de Existencia: se puede usar un toggle o select -->
                    <td class="px-2 py-1">
                        <select
                            x-model="item.existencia"
                            class="border rounded px-1 py-0.5">
                            <option value="" disabled>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </td>
                    <!-- Columna de Observaciones -->
                    <td class="px-2 py-1">
                        <input
                            type="text"
                            x-model="item.observaciones"
                            placeholder="Observaciones"
                            class="border rounded px-1 py-0.5 w-full" />
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</div>

</x-dynamic-component>
