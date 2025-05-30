

const mgEventCallback = {
    objectId: null,
    eventType: null,
    callbackFunction: null,
    order: 1000,
    
    generateEvent: function (id, eventType, callbackFunction, order) {
        if ((id === null || typeof id === 'string') && typeof eventType === 'string'
            && typeof callbackFunction === 'function')
        {
            this.objectId = id;
            this.eventType = eventType;
            this.callbackFunction = callbackFunction;
            this.order = (!order || typeof order !== 'number') ? 1000 : order;
            
            return this;
        } else
        {
            return null;
        }
        
    },
    runEventCallback: function (objectId, params) {
        return this.callbackFunction(objectId, params);
    }
};

/*
 * Events Handler
 * collects and run all events callbacks in the app
 */
const mgEventHandler = {
    callbacks: {},
    
    on: function (eventType, id, callbackFunction, order) {
        var tmpCall = mgEventCallback.generateEvent(id, eventType, callbackFunction, order);
        var tempId = Object.keys(this.callbacks).length;
        this.callbacks['call_' + tempId] = Object.assign({}, tmpCall);
    },
    
    runCallback: async function (eventType, id, callbackParams) {
        var callbackList = [];
        var self = this;
        for (var key in this.callbacks)
        {
            if (!this.callbacks.hasOwnProperty(key))
            {
                continue;
            }
            
            var tmpCallback = Object.assign({}, this.callbacks[key]);
            if (tmpCallback.eventType !== eventType || (tmpCallback.objectId !== null && tmpCallback.objectId !== id))
            {
                continue;
            } else if (tmpCallback.objectId !== null && tmpCallback.objectId === id)
            {
                callbackList.push(tmpCallback);
            } else
            {
                callbackList.push(tmpCallback);
            }
        }
        
        callbackList.sort(function (a, b) {
            return a.order - b.order
        });
        
        for (var key in callbackList)
        {
            if (!callbackList.hasOwnProperty(key))
            {
                continue;
            }
            
            await self.getPromise(callbackList[key], id, callbackParams).then(function () {
            
            });
        }
    },
    getPromise: function (calbackObj, id, callbackParams) {
        return new Promise(function (resolve, reject) {
            var ret = calbackObj.runEventCallback(id, callbackParams);
            if (ret || !ret)
            {
                resolve();
            }
        });
    }
};
