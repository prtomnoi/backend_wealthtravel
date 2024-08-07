const navbarLink = document.querySelectorAll('a.nav-link');
if(navbarLink){
    navbarLink.forEach((item,index) => {
        const currentPage = window.location.pathname.split('/').pop().split('.')[0];
        if(item.id == currentPage || (item.id == 'index' && currentPage == '')){
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}
