var component =
    {
        extends: BaseDataComponent,
        template: '#template-name#',
        mixins: [FormField],
        data: function () {
            return {
                multiple_: false,
                accept_: "",
                placeholder_: "",
                show_placeholder_: false,
            }
        },
        props: [
            'multiple',
            'accept',
            'placeholder'
        ],
        methods: {
            change: function (file) {
                this.show_placeholder_ = false;
            },
        },
        
        created: function () {
            this.show_placeholder_ = this.placeholder_.length > 0;
        },
    }