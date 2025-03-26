var component =
    {
        extends: BaseDataComponent,
        mixins: [ActionsHandlerMixin, TooltipMixin, VisibilityMixin],
        template: '#template-name#',
        data: function () {
            return {
                text_: '',
                css_: '',
                title_: '',
                leftTextPosition_: false
            }
        },
        props: [
            'text',
            'css',
            'title',
            'leftTextPosition',
        ],
        
    }