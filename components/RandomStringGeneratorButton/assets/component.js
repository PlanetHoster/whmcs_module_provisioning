var component =
    {
        extends: BaseDataComponent,
        template: '#template-name#',
        props: [
            'classes',
            'type',
            'title',
            'size',
            'clickEvent',
            'fieldToUpdate',
            'alphabet',
            'length',
            'css',
        ],
        data: function () {
            return {
                clickEvent_: 'click',
                fieldToUpdate_: '',
                length_: '',
                alphabet_: '',
                title_: '',
                css_: ''
            };
        },
        created: function () {
        },

        methods: {
            click: function (event) {
                event.preventDefault();

                this.$eventManager().setFieldValueById(this.fieldToUpdate_, this.generatePassword());

                this.$nextTick(() => {
                    $("#" + this.fieldToUpdate_).trigger("input");
                });
            },
            generatePassword: function () {
                let alphabetLength = this.alphabet_.length;
                let password = '';
                
                let numbersChars = '0123456789';
                let upperChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                let specialChars = '++++^^^^';
                let lowerChars = 'abcdefghijklmnopqrstuvwxyz';
                
                for (let i = 0; i < this.length; i++)
                {
                    password += this.alphabet_.charAt(Math.floor(Math.random() * alphabetLength));
                }
                
                for (let i = 0; i < 3; i++)
                {
                    password += numbersChars.charAt(Math.floor(Math.random() * numbersChars.length));
                }
                
                for (let i = 0; i < 3; i++)
                {
                    password += upperChars.charAt(Math.floor(Math.random() * upperChars.length));
                }
                
                for (let i = 0; i < 3; i++)
                {
                    password += specialChars.charAt(Math.floor(Math.random() * specialChars.length));
                }
                
                for (let i = 0; i < 3; i++)
                {
                    password += lowerChars.charAt(Math.floor(Math.random() * lowerChars.length));
                }
                
                return password;
            }
        }
    }