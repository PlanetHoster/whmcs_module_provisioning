var component =
    {
        extends: BaseDataComponent,
        mixins: [AjaxMixin, ComponentsContainer],
        template: '#template-name#',
        props: [
            'css',
            'elements',
            'title',
            'content',
        ],
        data: function () {
            return {
                css_: [],
                elements_: [],
                title_: "",
                content_: '',
            };
        },
        computed: {
        },
        created()
        {
        },
    }