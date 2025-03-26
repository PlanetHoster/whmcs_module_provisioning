const RequestHandler =
    {
        install(Vue, options)
        {
            let self = this;
            
            Vue.prototype.$request = function () {
                return self.installVue(this.$root);
            }
        },
        
        installVue(vue)
        {
            this.vue = vue;
            
            return this;
        },
        
        post(params)
        {
            params['ajax'] = 1;
            return this.request('post', mgUrlParser.getCurrentUrl(), params, {
                'Content-Type': 'multipart/form-data'
            });
        },
        
        get(params)
        {
            params['ajax'] = 1;
            
            return axios.get(mgUrlParser.getCurrentUrl(), {
                params: params
            });
        },
        
        request(type, url, params = {}, headers = {})
        {
            const formData = new FormData();
            this.buildFormData(formData, params);
            
            return axios({
                method: type,
                url: url,
                data: formData,
                headers: headers
            });
            
        },
        
        buildFormData(formData, data, parentKey)
        {
            if (typeof data === 'object' && data instanceof FormData)
            {
                for (const pair of data.entries())
                {
                    formData.append(this.formKeyName(parentKey + '[' + pair[0] + ']'), pair[1]);
                }
            } else if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File))
            {
                Object.keys(data).forEach(key => {
                    if (parentKey === "formData" && data[key])
                    {
                        data[key] = this.simplifyFormDataEntry(data[key]);
                    }
                    
                    this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                });
            } else
            {
                const value = data == null ? '' : data;
                formData.append(this.formKeyName(parentKey), value);
            }
        },
        
        formKeyName(key)
        {
            const split = key.replaceAll(']', '').split('[').filter(element => element);
            let out = '';
            
            if (split.length > 1)
            {
                for (let key in split)
                {
                    if (key == 0)
                    {
                        out += split[key];
                    } else
                    {
                        out += '[' + split[key] + ']';
                    }
                }
                
                if (key.includes('[]'))
                {
                    out += '[]';
                }
            }
            
            return out ? out : split;
        },

        simplifyFormDataEntry(entry)
        {
            if (typeof entry === 'object')
            {
                var newObject = {};

                Object.keys(entry).forEach(key => {
                    if (typeof entry[key] ===  'object' || Array.isArray(entry[key]))
                    {
                        return;
                    }

                    newObject[key] =  entry[key];
                });

                return newObject;
            }

            if (Array.isArray(entry))
            {
                return entry.flat();
            }

            return entry;
        },
    }
