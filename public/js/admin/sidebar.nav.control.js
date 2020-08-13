//SIDEBAR NAV CONTROL
(function(){
    const toggler = document.getElementById('sidenav-toggler');
    const sidenav = document.getElementById('sidebar-nav');
    const display = document.getElementById('content-display');
    const adminNav = document.getElementById('admin-nav');

    function collapseSidenav(){
        sidenav.classList.add('sidebar-collapsed');
        display.classList.add('full-page');
        adminNav.classList.remove('nav-collapsed');
    }
    function openSidenav(){
        sidenav.classList.remove('sidebar-collapsed');
        display.classList.remove('full-page');
        adminNav.classList.add('nav-collapsed');
    }

    //Hide Sidebar by default on small devices
    window.addEventListener('DOMContentLoaded', (event) => {
         if(window.innerWidth <= '840'){
            collapseSidenav();
         }else{
            openSidenav();
         }
    });
    window.addEventListener('resize', (event) => {
         if(window.innerWidth <= '840'){
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