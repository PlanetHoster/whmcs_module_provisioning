var component =
    {
        extends: BaseDataComponent,
        mixins: [AjaxMixin],
        template: '#template-name#',
        props: [
            'dataset',
            'data',
            'labels',
            'type',
            'options',
            'width',
            'height',
            'title',
            'icon',
            'config',
            'elements'
        ],
        data: function () {
            return {
                dataset_: {},
                labels_: {},
                type_: '',
                data_: {},
                options_: {},
                chart_: null,
                width_: '',
                height_: '',
                title_: '',
                icon_: '',
                config_: null,
                elements_: []
            };
        },
        created: function () {
            this.createChart();
        },
        computed: {
            iconClass: function () {
            
            },
        },
        methods: {
            ajaxLoaded_: function () {
                this.updateChart();
            },
            
            reload: function (input = null) {
                this.config_ = input.data ? input.data : {};
                this.loadDataFromServer_(this.config_, this.ajaxData_).then(this.updateChart);
            },
            
            createChart: function () {
                this.$nextTick(function () {
                    this.chart_ = new Chart(this.$refs.canvas, {
                        type: this.type_,
                    });
                    
                    this.$nextTick(this.updateChart());
                });
            },
            
            updateChart: function () {
                this.fixDataStructure();
                
                this.chart_.data = {
                    datasets: this.data_.datasets ? this.data_.datasets : {},
                    labels: this.data_.labels ? this.data_.labels : {},
                };
                
                this.chart_.options = this.options_ ? this.options_ : {}
                this.chart_.update();
            },
            
            //TODO: refactor this function to a recuring crowler
            fixDataStructure: function ()
            {
                var varsToBeConverted = [
                    'backgroundColor', 'borderColor', 'data', 'hoverBackgroundColor',
                    'hoverBorderColor', 'pointBackgroundColor', 'pointBorderColor', 'pointHoverBackgroundColor', 'pointHoverBorderColor'
                ];
                
                for (var key in this.data_.datasets)
                {
                    if (!this.data_.datasets.hasOwnProperty(key))
                    {
                        continue;
                    }
                    
                    var tmpObj = this.data_.datasets[key];
                    for (var convKey in varsToBeConverted)
                    {
                        if (typeof tmpObj[varsToBeConverted[convKey]] === 'object')
                        {
                            this.data_.datasets[key][varsToBeConverted[convKey]] = Object.values(tmpObj[varsToBeConverted[convKey]]);
                        } else if (typeof tmpObj[varsToBeConverted[convKey]] !== 'undefined')
                        {
                            this.data_.datasets[key][varsToBeConverted[convKey]] = tmpObj[varsToBeConverted[convKey]];
                        } else
                        {
                            //do nothing
                        }
                    }
                }
                if (typeof this.data_.labels !== 'undefined')
                {
                    this.options_.labels = Object.values(this.data_.labels);
                }
                if (typeof this.options_.scales !== 'undefined' && typeof this.options_.scales.xAxes !== 'undefined')
                {
                    this.options_.scales.xAxes[0].labels = Object.values(this.data_.labels);
                }
                if (typeof this.options_.scales !== 'undefined' && typeof this.options_.scales.xAxes !== 'undefined' && typeof this.options_.scales.xAxes[0] !== 'undefined'
                    && typeof this.options_.scales.xAxes[0].ticks !== 'undefined' && typeof this.options_.scales.xAxes[0].ticks.callback !== 'undefined')
                {
                    if (typeof this.options_.scales.xAxes[0].ticks.callbackFN === 'undefined')
                    {
                        this.options_.scales.xAxes[0].ticks.callbackFN = this.options_.scales.xAxes[0].ticks.callback;
                    }
                    
                    var tmpCallbackName = this.options_.scales.xAxes[0].ticks.callbackFN;
                    var tmpCallbackFunction = window[tmpCallbackName];
                    
                    this.options_.scales.xAxes[0].ticks.callback = tmpCallbackFunction;
                }
                
                if (typeof this.options_.scales !== 'undefined' && typeof this.options_.scales.yAxes !== 'undefined' && typeof this.options_.scales.yAxes[0] !== 'undefined'
                    && typeof this.options_.scales.yAxes[0].ticks !== 'undefined' && typeof this.options_.scales.yAxes[0].ticks.callback !== 'undefined')
                {
                    if (typeof this.options_.scales.yAxes[0].ticks.callbackFN === 'undefined')
                    {
                        this.options_.scales.yAxes[0].ticks.callbackFN = this.options_.scales.yAxes[0].ticks.callback;
                    }
                    
                    var tmpCallbackName = this.options_.scales.yAxes[0].ticks.callbackFN;
                    var tmpCallbackFunction = window[tmpCallbackName];
                    
                    this.options_.scales.yAxes[0].ticks.callback = tmpCallbackFunction;
                }
                
                if (typeof this.options_.tooltips !== 'undefined' && typeof this.options_.tooltips.callbacks !== 'undefined'
                    && typeof this.options_.tooltips.callbacks.label !== 'undefined')
                {
                    if (typeof this.options_.tooltips.callbacks.labelCallbackFN === 'undefined')
                    {
                        this.options_.tooltips.callbacks.labelCallbackFN = this.options_.tooltips.callbacks.label;
                    }
                    
                    var tmpCallbackName = this.options_.tooltips.callbacks.labelCallbackFN;
                    var tmpCallbackFunction = window[tmpCallbackName];
                    
                    this.options_.tooltips.callbacks.label = tmpCallbackFunction;
                }
            }
        }
    }