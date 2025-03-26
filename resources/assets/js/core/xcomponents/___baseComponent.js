const BaseComponent = {
    components: vueComponents,
    mixins: [
        TranslatorMixin
    ],
    props: [
        'cid',
        'namespace',
        'uniq'
    ],
    data: function () {
        return {
            uniq_: null,
        }
    },
    created()
    {
    },
    computed: {
        cid_: {
            get() {
                return this.cid;
            },
            set(newValue) {
            }
        }
    }
};