// const objGateway = {
//     name: null,
//     value: null
// };
export default {
    methods: {
        toPropertyValue(items) {
            let arr = [];
            if (!items) return arr;
            items.forEach(function(item, index) {
                let temp = {};
                temp[item.name] = item.value;
                arr.push(temp);
            });
            return arr;
        },
        toKeyValue(items) {
            let arr = [];
            if (!items) return arr;
            items.forEach(function(item, index) {
                let obj = Object.create(item);
                let getKey = Object.keys(item).toString();
                obj.name = getKey;
                obj.value = item[getKey];
                arr.push(obj);
            });
            return arr;
        }
    }
};
