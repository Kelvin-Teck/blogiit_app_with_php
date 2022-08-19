const selectElement = (selector) => {
  const element = document.querySelector(selector);
  if (element) return element;
  throw new Error(
    `Something went wrong, make sure that ${selector} exists or is typed correctly`
  );
};

const navItems = selectElement('.nav__items');
const openNavBtn = selectElement("#open__nav-btn");
const closeNavBtn = selectElement("#close__nav-btn");

// Open the navigation dropdown...
const openNav = () => {
    navItems.style.display = 'flex';
    openNavBtn.style.display = 'none';
    closeNavBtn.style.display = 'inline-block';
}

// Close the navigation dropdown...
const closeNav = () => {
  navItems.style.display = "none";
  openNavBtn.style.display = "inline-block";
  closeNavBtn.style.display = "none";
};


openNavBtn.addEventListener('click', openNav);
closeNavBtn.addEventListener("click", closeNav);


// DASHBOARD
const sideBar = selectElement("aside");
const showSidebarBtn= selectElement("#show__sidebar-btn");
const hideSidebarBtn = selectElement("#hide__sidebar-btn");

// Show sidebar function for small devices...
const showSideBar = () => {
  sideBar.style.left = '0';
  showSidebarBtn.style.display = 'none';
  hideSidebarBtn.style.display = 'block';
}

// Hide sidebar function for small devices...
const hideSideBar = () => {
  sideBar.style.left = '-100%';
  showSidebarBtn.style.display = 'inline-block';
  hideSidebarBtn.style.display = 'none';
}

showSidebarBtn.addEventListener('click', showSideBar);
hideSidebarBtn.addEventListener("click", hideSideBar);

