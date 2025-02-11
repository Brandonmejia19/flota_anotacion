<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="fuelGaugeComponent()" x-init="init()">
        <!-- Input oculto para almacenar el valor en el formulario -->
        <input type="hidden" name="{{ $getStatePath() }}" x-model="fuelLevel">

        <!-- Canvas donde se renderiza el gauge de gasolina -->
        <canvas id="fuelGauge-{{ $getStatePath() }}" style="width:80%; height:200px;"></canvas>

        <!-- Elemento para mostrar el porcentaje actual -->
        <div class="text-center mt-2 text-xl font-bold" x-text="fuelLevel + '%'"></div>

        <!-- Slider para ajustar el nivel de gasolina -->
        <div class="mt-2">
            <input
                type="range"
                min="0"
                max="100"
                x-model="fuelLevel"
                x-on:input="updateGauge()"
                class="w-full"
            >
        </div>
    </div>

    <!-- Incluir la librería gauge.js desde CDN -->
    <script src="https://bernii.github.io/gauge.js/dist/gauge.min.js"></script>

    <script>
        function fuelGaugeComponent(){
            return {
                // Valor inicial (50 por defecto o el valor guardado)
                fuelLevel: @js($getState() ?? 50),
                gauge: null,
                init(){
                    // Opciones de configuración para el gauge
                    var opts = {
                        angle: 0.15,          // Ángulo del arco (aprox. 8.6° en cada lado)
                        lineWidth: 0.44,      // Grosor del arco
                        radiusScale: 1,       // Escala del radio
                        pointer: {
                            length: 0.6,      // Longitud del puntero (60% del radio)
                            strokeWidth: 0.035, // Grosor del puntero
                            color: '#000000'  // Color del puntero
                        },
                        limitMax: false,      // Permite que el gauge supere el máximo definido
                        limitMin: false,
                        colorStart: '#1307b5',// Color inicial del gradiente
                        colorStop: '#1307b5', // Color final del gradiente
                        strokeColor: '#E0E0E0', // Color del trazo
                        generateGradient: true,
                        highDpiSupport: true  // Soporte para pantallas de alta resolución
                    };

                    // Obtenemos el canvas por su id único
                    var target = document.getElementById('fuelGauge-{{ $getStatePath() }}');

                    // Creamos la instancia del gauge y le aplicamos las opciones
                    this.gauge = new Gauge(target).setOptions(opts);
                    this.gauge.maxValue = 100;
                      // Valor máximo (100%)
                    this.gauge.setMinValue(0);   // Valor mínimo
                    this.gauge.animationSpeed = 32; // Velocidad de la animación

                    // Inicializamos el gauge con el valor actual
                    this.gauge.set(this.fuelLevel);
                },
                staticLabels: {
                font: "10px sans-serif",
                labels: [10, 13, 15, 22, 26, 30],
                color: "#000000",
                },
                updateGauge(){
                    // Cada vez que se mueva el slider, actualizamos el gauge
                    if (this.gauge) {
                        this.gauge.set(this.fuelLevel);
                    }
                }
            }
        }
    </script>
</x-dynamic-component>
