(()=>{window.addEventListener("load",function(){d()});document.addEventListener("livewire:navigated",()=>{d()});function d(){let s=document.querySelector(".fi-topbar"),e=document.querySelector(".fi-main"),t=document.querySelector(".fi-header");if(s&&e&&t&&filamentData!=null&&filamentData.stickyHeaderActive){let i=document.createElement("div"),a=(filamentData==null?void 0:filamentData.stickyHeaderTheme)||"default";i.classList.add("filament-sticky-trigger"),e.prepend(i),e.classList.add(`sticky-theme-${a}`);let o=s.offsetHeight,n=null;new IntersectionObserver(([r])=>{if(r.isIntersecting){if(n&&r.time-n<1e3)return;n=r.time,e.classList.remove("is-sticky");return}let c=0;a.includes("floating")&&(c+=8),t.style.top=o+c+"px",t.setAttribute("wire:ignore.self","true"),e.classList.add("is-sticky")},{rootMargin:`-${o}px`,threshold:[0]}).observe(i)}}})();
