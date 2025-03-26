var component =
    {
        components: vueComponents,
        template: '#template-name#',
        props: [
            'element',
            'autoHideFieldName',
            'autoHideFieldValue',
            'autoDisableFieldName',
            'autoDisableFieldValue',
            'cid'
        ],
        methods: {
            checkHidden: function () {
                return this.autoHideFieldName &&
                    typeof this.$attrs.data != 'undefined' &&
                    this.$attrs.data[this.autoHideFieldName] == this.autoHideFieldValue;
            },
            
            checkDisabled: function () {
                return this.autoDisableFieldName &&
                    typeof this.$attrs.data != 'undefined' &&
                    this.$attrs.data[this.autoDisableFieldName] == this.autoDisableFieldValue;
            },
            
            disabledClass: function () {
                return this.checkDisabled() ? 'disabled' : "";
            },
            
            hiddenClass: function () {
                return this.checkHidden() ? 'hidden' : "";
            }
        },
        computed: {
            params_: function () {
                let element = this.element;
                element.slots['class'] = this.disabledClass() + " " + this.hiddenClass();

                let finalActions = this.clearActions ? {} : element.slots['actions'];
                this.clearActions = false;

                return {
                    ...element.slots,
                    ...this.$attrs,
                    ...{
                        actions: finalActions,
                    },
                };
            },
            cid_: function() {
                return this.cid;
            }
        }
    }