export default { 
    capFirstLetter(val) {
        return val ? val.charAt(0).toUpperCase() + val.slice(1) : '';
    },
};