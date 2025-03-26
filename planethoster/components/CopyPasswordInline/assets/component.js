var component =
    {
        extends: BaseDataComponent,
        template: '#template-name#',
        props: [
            'data',
            'classes',
            'type',
            'text',
            'icon',
            'title',
            'size',
            'copySelector',
            'copyType',
            'css',
            'title',
            'is_visible'
        ],
        data: function () {
            return {
                show_title: true,
                data_: null,
                icon_: '',
                type_: '',
                size_: '',
                copySelector_: '',
                copyType_: '',
                isCopied_: false,
                css_: '',
                title_: '',
                text_: '',
                is_visible_: false
            };
        },

        methods: {
            onIconClick: function (event) {
                event.preventDefault();
                
                navigator.clipboard.writeText(this.text_).then(function () {
                    this.$alertManager().success(this.translate_('text_copied'));
                    this.isCopied_ = true;
                    
                    setTimeout(function () {
                        this.isCopied_ = false
                    }.bind(this), 3000);
                }.bind(this));
            },
            onTextClick: function(){
                this.is_visible_ = !this.is_visible_;
            }
        },
    }