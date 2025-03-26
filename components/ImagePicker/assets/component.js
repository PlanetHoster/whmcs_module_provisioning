var component =
    {
        extends: BaseDataComponent,
        template: '#template-name#',
        mixins: [FormField],
        data: function () {
            return {
                mediaLibrary_: false,
                isOpen_: false,
                disableSearching_: false,
                searchedPhrase_: "",
                dropdownHeightClass_: "",
                currentImageUrl_: '',
            }
        },
        props: [
            'mediaLibrary',
            'isOpen',
            'disableSearching',
            'searchedPhrase',
            'dropdownHeightClass',
            'currentImageUrl'
        ],
        created: function () {
            window.addEventListener('click', this.hideWhenClickOutside);
        },
        destroyed: function () {
            window.removeEventListener('click', this.hideWhenClickOutside);
        },
        methods: {
            change: function (e) {
                this.value_ = e.imageName;
                this.hideDropdown();
            },
            toggleDropdown: function () {
                $("#" + this.cid_ + " div.selectize-dropdown").toggle();
                this.isOpen_ = !this.isOpen_;
            },
            openDropdown: function () {
                setTimeout(() => {
                    $("#" + this.cid_ + " div.selectize-dropdown").show();
                    this.isOpen_ = true;
                    if (!this.disableSearching_ && !this.value_)
                    {
                        this.$nextTick(function () {
                            $("#" + this.cid_ + " input.lu-selectize-search-input").focus();
                        });
                    }
                }, 10);
            },
            hideDropdown: function () {
                $("#" + this.cid_ + " div.selectize-dropdown").hide();
                this.isOpen_ = false;
                this.searchedPhrase_ = "";
            },
            clearField: function (e) {
                this.value_ = null;
                e.stopPropagation()
            },
            hideWhenClickOutside: function (event) {
                if (this.isOpen_ && !this.$el.contains(event.target))
                {
                    this.hideDropdown();
                }
            },
            updateSearchedPhrase: function (event) {
                this.searchedPhrase_ = event.target.value;
            },
            getCssClass: function (event) {
                return this.css_ + (this.isOpen_ ? ' is-open' : "");
            },
        }
    }