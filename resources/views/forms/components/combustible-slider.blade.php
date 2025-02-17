<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="fuelGaugeComponent()" x-init="init()" x-effect="updateGauge()">
        <!-- Input oculto para almacenar el valor en el formulario -->
        <input type="hidden" name="{{ $getStatePath() }}" x-model="fuelLevel" x-on:change="$wire.set('{{ $getStatePath() }}', fuelLevel)">

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
                x-on:change="$wire.set('{{ $getStatePath() }}', fuelLevel)"
                class="w-full"
            >
        </div>
    </div>

    <!-- Incluir la librería gauge.js desde CDN -->
    <script src="https://bernii.github.io/gauge.js/dist/gauge.min.js"></script>

    <script>
        function fuelGaugeComponent() {
            return {
                fuelLevel: @js($getState() ?? 50), // Inicializa con el valor del estado
                gauge: null,
                init() {
                    this.renderGauge();
                },
                renderGauge() {
                    var opts = {
                        angle: 0.15,
                        lineWidth: 0.44,
                        radiusScale: 1,
                        pointer: {
                            length: 0.6,
                            strokeWidth: 0.035,
                            color: '#000000'
                        },
                        limitMax: false,
                        limitMin: false,
                        colorStart: '#1307b5',
                        colorStop: '#1307b5',
                        strokeColor: '#E0E0E0',
                        generateGradient: true,
                        highDpiSupport: true
                    };

                    var target = document.getElementById('fuelGauge-{{ $getStatePath() }}');

                    this.gauge = new Gauge(target).setOptions(opts);
                    this.gauge.maxValue = 100;
                    this.gauge.setMinValue(0);
                    this.gauge.animationSpeed = 32;
                    this.gauge.set(this.fuelLevel);
                },
                updateGauge() {
                    if (!this.gauge) {
                        this.renderGauge();
                    }
                    this.gauge.set(this.fuelLevel);
                }
            };
        }
    </script>
</x-dynamic-component>
