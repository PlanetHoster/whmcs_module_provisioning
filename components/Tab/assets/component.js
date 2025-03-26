var component =
    {
        extends: BaseDataComponent,
        mixins: [AjaxMixin],
        template: '#template-name#',
        props: [
            'classes',
            'content',
            'title',
            'elements',
        ],
        
        data: function () {
            return {
                elements_: [],
                content_: '',
            };
        },
        computed: {
            paddingClass: function () {
                return '';
            }
        },
    }