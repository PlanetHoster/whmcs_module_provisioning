var component =
    {
        extends: BaseDataComponent,
        mixins: [FormField],
        template: '#template-name#',
        created: function (){
            this.$nextTick(function(){
                new JSColor(this.$refs.input);
            }.bind(this));
        },
    }