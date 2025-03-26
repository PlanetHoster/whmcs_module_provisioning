var component =
    {
        extends: BaseDataComponent,
        template: '#template-name#',
        props: [
            'fill',
            'text',
            'size',
            'backgroundClass',
            'descriptionTooltip'
        ],
        
        data: function () {
            return {
                fill_: 0,
                text_: '',
                size_: '',
                backgroundClass_: '',
                descriptionTooltip_: null
            }
        },
        
        created: function () {
        },
    
        methods: {
        },
        
        computed: {
            fillStyle: function () {
                return "width: " + this.fill_ + "%";
            },
    
            sizeClass: function () {
                return "lu-progress--" + this.size_;
            },
        },
    }