const prepareData = (payload) => {
    payload = renameKey(payload, "sortBy", "sort");

    if (payload.sortDesc[0]) {
        payload.sort = "-" + payload.sort;
    }

    payload.sort === "-" ? (payload.sort = "") : payload.sort;

    return payload;
};

const renameKey = (object, key, newKey) => {
    const clonedObj = clone(object);
    const targetKey = clonedObj[key];
    delete clonedObj[key];
    clonedObj[newKey] = targetKey;
    return clonedObj;
};

const clone = (obj) => Object.assign({}, obj);

export default prepareData;
