export default (value) => {
    if (value[window.Laravel.locale] &&  value[window.Laravel.locale]!=='') {
        return value[window.Laravel.locale];

    }
    else {
        return value['en']

    }
}

