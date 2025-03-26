var component =
    {
        extends: BaseDataComponent,
        template: '#template-name#',
        props: [
            'css',
            'description',
            'additionalDescription',
            'title',
            'elements',
        ],
        data: function () {
            return {
                elements_: [],
                description_: '',
                additionalDescription_: '',
                title_: '',
                css_: [],
            };
        },
        created: function () {
        
        },
        
    }