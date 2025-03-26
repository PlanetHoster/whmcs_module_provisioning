var component =
    {
        extends: BaseDataComponent,
        template: '#template-name#',
        data: function () {
            return {
                text_: '',
                css_: '',
                elements_: '',
                content_: '',
                error_: '',
                fieldName_: '',
            }
        },
        props: [
            'text',
            'css',
            'elements',
            'content',
            'error',
            'fieldName',
        ],
        created: function () {
            if (!this.fieldName_)
            {
                return;
            }
            
            this.$eventManager().onSetFieldError(this.fieldName_, function (message) {
                this.error_ = message;
            }.bind(this));
            
            this.$eventManager().onResetFormErrors(function () {
                this.error_ = '';
            }.bind(this))
        },

        methods: {},
        computed: {
            formGroupClass: function () {
                return this.css_ + (this.error_ ? ' lu-is-error' : '');
            }
        }
    }