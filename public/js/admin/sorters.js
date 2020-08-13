(function(){
    const sorters = $('.sorter');
    var targetUrl = window.location.href;
    var remainder, sort, initialSortColumn;

    //Add event listeners to sorter buttons
    $(sorters).each(function(index, element){
        $(element).on('click', ()=>{
            //Append Separator to target url
            targetUrl += (targetUrl.includes("?")) ? '&' : '?';
            //Get new sort value
            let sortColumn = $(this).parent().find('.col-name').attr('data-target').toLowerCase();
            //if sort does not exist, add sort
            if(!targetUrl.includes("sort=")){
                appendSort(sortColumn);
            }else{
                //Get current sort column and order
                 remainder = targetUrl.substring(targetUrl.lastIndexOf('sort='));
                 sort = remainder.substring(remainder.indexOf('=')+1, remainder.indexOf('&'));
                 initialSortColumn = !sort.includes(":") ? sort : sort.substring(0, sort.indexOf(':'));

                //if initial sort column is not same as new value, replace the sorting, else reverse the sorting
                if(initialSortColumn.toLowerCase() !== sortColumn){
                    replaceSort(sort, sortColumn);
                }else{
                    reverseSort(sort, sortColumn);
                }
            }
        });

        // Add Sorting if does not exist
        function appendSort(sortColumn){
            targetUrl += `sort=${sortColumn}`;
            loadTarget();
        }
        // Replace the whole sorting
        function replaceSort(sort, sortColumn){
            targetUrl = targetUrl.replace(sort, sortColumn);
            loadTarget();
        }

        // Reverse sort order
        function reverseSort(sort, sortColumn){
            let order = 'DESC';
            if(sort.includes(':') && sort.substring(sort.indexOf(':')+1).toUpperCase() !== 'ASC'){
                order = 'ASC';
            }
            targetUrl = targetUrl.replace(sort, `${sortColumn}:${order}`);
            loadTarget();
        }

        // Redirect to the built url
        function loadTarget(){
            targetUrl = targetUrl.endsWith('&') ? targetUrl.slice(0, -1) : targetUrl;
            window.location.href = targetUrl;
        }
    });
})();