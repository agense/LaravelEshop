(function(){
    //SIDEBAR NAV CONTROL
    const toggler = document.getElementById('sidenav-toggler');
    const sidenav = document.getElementById('sidebar-nav');
    const display = document.getElementById('content-display');

    function collapseSidenav(){
        sidenav.classList.add('sidebar-collapsed');
        display.classList.add('full-page');
    }
    function openSidenav(){
        sidenav.classList.remove('sidebar-collapsed');
        display.classList.remove('full-page');
    }

    //Hide Sidebar by default on small devices
    window.addEventListener('DOMContentLoaded', (event) => {
         if(window.innerWidth <= '768'){
            collapseSidenav();
         }else{
            openSidenav();
         }
    });
    window.addEventListener('resize', (event) => {
         if(window.innerWidth <= '768'){
            collapseSidenav();
         }else{
            openSidenav();
         }
    });
    //toggle sidebar navigation
    toggler.parentElement.addEventListener('click', function(){
        if(!sidenav.classList.contains('sidebar-collapsed')){
            collapseSidenav();
        }else{
            openSidenav();
        }
    });
})();