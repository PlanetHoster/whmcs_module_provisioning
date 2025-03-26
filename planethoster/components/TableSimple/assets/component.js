var component =
    {
        extends: BaseDataComponent,
        mixins: [AjaxMixin],
        template: '#template-name#',
        props: [
            'columns',
            'records',
            'textCentered'
        ],
        data: function () {
            return {
                columns_: [],
                records_: [],
                textCentered_: false
            };
        },
        created()
        {
        },
        computed: {
            textCenterClass: function () {
                return this.textCentered_ ? 'lu-text-center' : ''
            },
        }
    }