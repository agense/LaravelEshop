(function(){
    const searchForm = $('#search-form');
    const filterForm = $('#filter-form');
    
    //Handle Search Form
    searchForm.on('submit', function(e){
        e.preventDefault();
        let targetUrl = $(searchForm).attr('action');
        let data = $(searchForm).find('#search').val();

        if(valueExists(data)){
            targetUrl += `?search=${data}`;
            window.location.href = targetUrl;
        }else{
            toastr.error('Search form is empty');
        };
    });

    //Handle Filter Form
    filterForm.on('submit', function(e){
        e.preventDefault();
        let targetUrl = $(filterForm).attr('action');

        let data = getData();
        let query = buildQuery(data);

        if(query.length > 0){
            targetUrl += query;
            window.location.href = targetUrl;
        }else{
            toastr.error('No filters were selected');
        };
    });

    function buildQuery(data){
        let q = "?";
        for (let [key, value] of Object.entries(data)) {
            if(valueExists(value)){
                q += `${key}=${value}&`;
            }
        }
        if(q.endsWith('&') || q.endsWith('?')){
            q = q.slice(0, -1);
        } 
        return q;
    }
    
    function getData(){
      let data = {};
      let selectors = $('input, radio, select, date').not(':input[type=file],:input[type=button], :input[type=submit], :input[type=hidden]');
      $(filterForm).find(selectors).each(function(index, elem){
        //get input name
        let name = $(elem).attr('name');

        if($(elem).is('select')){
            data[name] = $(elem).find(":selected").val();
        }else if($(elem).is(':radio')){
            if($(elem).is(':checked')){
                data[name] = $(elem).val();
            }
        }else{
            data[name] = $(elem).val();
        }
      });
      return data;
    }

    //Helper - checks if a field has value
    function valueExists(value){
        if(value == undefined || value == null || value.trim() == "" || value.length <= 0){
            return false;
        }else{
            return true;
        }
    }
   
})();