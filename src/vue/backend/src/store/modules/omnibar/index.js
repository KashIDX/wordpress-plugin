const state = {
    cityListOptions: [],
    cityListSelected: '',
    countyListOptions: [],
    countyListSelected: '',
    postalCodeListOptions: [],
    postalCodeSelected: '',
    defaultPropertyTypeSelected: '',
    mlsMembership: [],
    autofillMLSSelected: [],
    customFieldsSelected: [],
    customFieldsOptions: [],
    customPlaceholder: 'City, Postal Code, Address, or Listing ID',
    defaultSortOrderSelected: 'newest'
}

export default {
    namespaced: true,
    state
}
