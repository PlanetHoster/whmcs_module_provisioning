var component =
    {
        extends: BaseDataComponent,
        mixins: [AjaxMixin],
        template: '#template-name#',
        data: function () {
            return {
                text_: '',
                type_: '',
                outline_: ''
            }
        },
        props: [
            'text',
            'type',
            'outline',
        ],
        created: function () {
        },
        computed: {
            badgeType: function () {
                return this.type_ ? 'lu-badge--' + this.type_ : '';
            },
            outlineClass: function () {
                return this.outline_ ? 'lu-badge--outline' : null;
            },
        }
    }