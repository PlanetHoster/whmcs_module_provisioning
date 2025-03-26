var component =
    {
        extends: BaseDataComponent,
        mixins: [FormField, ActionsHandlerMixin],
        template: '#template-name#',
        props: [
            "autoSaveEnabled"
        ],
        data() {
            return {
                simplemde: null,
                autoSaveEnabled_: false
            }
        },
        created: function () {
            this.$nextTick(function () {
                this.simplemde = new SimpleMDE({ element: document.getElementById(this.cid_),autosave: {enabled:this.autoSaveEnabled_, uniqueId: this.cid_}, spellChecker: false});
        
                if (this.value_ !== null)
                {
                    this.simplemde.value(this.value_)
                } else {
                    this.value_ = this.autoSaveEnabled_ ? this.value_ : this.simplemde.value();
                }
        
                this.simplemde.codemirror.on("change", () => {
                    this.value_ = this.simplemde.value()
                });
            })
        },
    }
