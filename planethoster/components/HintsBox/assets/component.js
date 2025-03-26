var component =
    {
        extends: BaseDataComponent,
        mixins: [AjaxMixin],
        template: '#template-name#',
        props: [
            'title',
            'elements',
        ],
        data: function () {
            return {
                title_: '',
                elements_: [],
            };
        },
    }