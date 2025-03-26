var component =
    {
        extends: BaseDataComponent,
        template: '#template-name#',
        props: [
            'css',
            'content',
            'title',
            'elements',
        ],
        data: function () {
            return {
                elements_: [],
                css_: [],
                title_: '',
                content_: ''
            };
        },
        created: function () {
        },

        computed: {
        }
    }