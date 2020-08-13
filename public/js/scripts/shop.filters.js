(function(){

    //SORTING
    const sorters = $('.shop-sorter');
    $(sorters).each(function(index, element){
        $(element).on('click', (e)=>{
            e.preventDefault();
            applySort(element);
        })
    });

    // FILTERING
    const filterForm = $('#shop-filter-form');
    var checkboxTypes;

    filterForm.on('submit', function(e){
        e.preventDefault();
        let targetUrl = $(filterForm).attr('action');

        //Build filter options
        checkboxTypes = buildFilterOptions();

        let data = getData();
        let query = buildQuery(data);

        if(query.length > 0){
            let prefix = queryBeforeFilters();
            targetUrl += `?${prefix}${query}`;
            window.location.href = targetUrl;
        }else{
            toastr.error('No filters were selected');
        };
    });

    //Build filter options
    function buildFilterOptions(){
        let types = ['brand'];
        const featureTypes = $('.features');
    
        Object.values(featureTypes).forEach(ftype => {
            let filterType = $(ftype).attr('data-type');
            if (typeof filterType !== typeof undefined && filterType !== false) {
                types.push(filterType);
            }
        });
        return types;
    }


    // Build filter query from filter data
    function buildQuery(data){
        let q = "";
        for (let [key, value] of Object.entries(data)) {
            q += `${key}=${value}&`;
        }
        if(q.endsWith('&') || q.endsWith('?')){
            q = q.slice(0, -1);
        } 
        return q;
    }

    
    //Prefix the url with query before filters
    function queryBeforeFilters(){
        let fullUrl = window.location.href;
        //Prepend with category value if exists
        if(fullUrl.includes("category=")){
            return fullUrl.substring(fullUrl.lastIndexOf('category='))+"&";
        }
        return "";
    }
    
     // Builds an arrays of filter data
    function getData(){ 
        let data = {};
        checkboxTypes.forEach(type => {
            let checkedValues = getChecked(type);
            if(checkedValues.length > 0){
                data[type] = checkedValues;
            }    
        });
        return data;
    }

    // Gets all checked values of input wth specified name
    function getChecked(iName){
        let valStr = "";
        $.each($(`input[name='${iName}']:checked`), function (index, el) { 
            valStr += `${el.value}:`;        
        });
        if(valStr.endsWith(':') ){
            valStr = valStr.slice(0, -1);
        }
        return valStr;
    }

    // Apply sort query to url
    function applySort(sortElement){
        let sortUrl = window.location.href;
        const sortVal = $(sortElement).attr('data-filter');

        // Remove current sort if exists
        if(sortUrl.includes("sort=")){
            sortUrl = sortUrl.substring( 0, sortUrl.lastIndexOf('sort=') );
        }
        if(!sortUrl.endsWith('&')){
            sortUrl += '&';
        }
        // Append new sort
        let newUrl = `${sortUrl}sort=${sortVal}`;
        window.location.href = newUrl;
    }

})();
