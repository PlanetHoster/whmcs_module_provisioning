var component =
    {
        extends: BaseDataComponent,
        mixins: [FormField, ActionsHandlerMixin],
        template: '#template-name#',
        components: {
            vuejsDatepicker
        },
        props: [
            'format',
            'placeholder'
        ],
        
        data: function () {
            return {
                format_: '',
                placeholder_: ''
            };
        },
        created: function () {
            window.addEventListener('click', this.hideWhenClickOutside);
        },
        destroyed: function () {
            window.removeEventListener('click', this.hideWhenClickOutside);
        },
        methods: {
            hideWhenClickOutside: function (event) {
                datePicker = this.$refs[this.cid_]
                
                if (typeof datePicker != "undefined" && datePicker.isOpen && !this.$el.contains(event.target))
                {
                    datePicker.close();
                }
            },
            onChangeDate: function () {
                this.onChange();
            },
        }
    }