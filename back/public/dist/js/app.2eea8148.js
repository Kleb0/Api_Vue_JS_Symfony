(function(){"use strict";var e={726:function(e,t,o){var r=o(3751),s=o(641),a=o(33);const l={class:"navbar"},n={class:"user-info"},i={key:0,class:"divider"},c={key:1,class:"admin-info"};function u(e,t,o,r,u,m){const d=(0,s.g2)("router-link"),f=(0,s.g2)("router-view");return(0,s.uX)(),(0,s.CE)(s.FK,null,[(0,s.Lk)("nav",l,[(0,s.bF)(d,{to:"/"},{default:(0,s.k6)((()=>t[1]||(t[1]=[(0,s.eW)("Home")]))),_:1}),t[7]||(t[7]=(0,s.eW)(" | ")),(0,s.bF)(d,{to:"/about"},{default:(0,s.k6)((()=>t[2]||(t[2]=[(0,s.eW)("About")]))),_:1}),t[8]||(t[8]=(0,s.eW)(" | ")),r.isLoggedIn?((0,s.uX)(),(0,s.CE)(s.FK,{key:1},[(0,s.Lk)("button",{onClick:t[0]||(t[0]=(...e)=>r.logout&&r.logout(...e)),class:"btn-logout"},"Logout"),(0,s.Lk)("div",n,[(0,s.Lk)("span",null," Hello, "+(0,a.v_)(r.userFirstName),1),"ADMIN"===r.userRoleName?((0,s.uX)(),(0,s.CE)("hr",i)):(0,s.Q3)("",!0),"ADMIN"===r.userRoleName?((0,s.uX)(),(0,s.CE)("span",c,t[6]||(t[6]=[(0,s.eW)(" Vous êtes "),(0,s.Lk)("span",{class:"admin-highlight"},"Admin",-1)]))):(0,s.Q3)("",!0)])],64)):((0,s.uX)(),(0,s.CE)(s.FK,{key:0},[(0,s.bF)(d,{to:"/register"},{default:(0,s.k6)((()=>t[3]||(t[3]=[(0,s.eW)(" Register")]))),_:1}),t[5]||(t[5]=(0,s.eW)(" | ")),(0,s.bF)(d,{to:"/login"},{default:(0,s.k6)((()=>t[4]||(t[4]=[(0,s.eW)("Login")]))),_:1})],64))]),(0,s.bF)(f)],64)}var m=o(953),d=o(4335),f={setup(){const e=(0,m.KR)(!1),t=(0,m.KR)(localStorage.getItem("userFirstName")||""),o=(0,m.KR)(localStorage.getItem("userRoleName")||""),r=()=>{t.value=localStorage.getItem("userFirstName")||"",o.value=localStorage.getItem("userRoleName")||""},a=async()=>{const t=localStorage.getItem("token");if(t)try{const o=await d.A.get("http://localhost:8000/api/check-token",{headers:{Authorization:`Bearer ${t}`}});e.value=200===o.status}catch(o){console.error("Token invalide ou expiré:",o),localStorage.removeItem("token"),localStorage.removeItem("user"),localStorage.removeItem("userFirstName"),localStorage.removeItem("userRoleName")}},l=async()=>{try{await d.A.post("http://localhost:8000/api/logout",{},{withCredentials:!0,headers:{Authorization:`Bearer ${localStorage.getItem("token")}`}}),localStorage.clear(),e.value=!1,localStorage.setItem("userFirstName",""),localStorage.setItem("userRoleName","")}catch(t){console.error("Error during disconnection:",t)}};return(0,s.wB)(e,(e=>{e&&r()})),(0,s.sV)((()=>{a(),r()})),(0,s.Gt)("isLoggedIn",e),(0,s.Gt)("updateUserInfo",r),{isLoggedIn:e,userFirstName:t,userRoleName:o,logout:l}}},g=o(6262);const p=(0,g.A)(f,[["render",u],["__scopeId","data-v-31325c2c"]]);var b=p,h=o(5220),k="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyNpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDE0IDc5LjE1Njc5NywgMjAxNC8wOC8yMC0wOTo1MzowMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6OTk2QkI4RkE3NjE2MTFFNUE4NEU4RkIxNjQ5MTYyRDgiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6OTk2QkI4Rjk3NjE2MTFFNUE4NEU4RkIxNjQ5MTYyRDgiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NjU2QTEyNzk3NjkyMTFFMzkxODk4RDkwQkY4Q0U0NzYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NjU2QTEyN0E3NjkyMTFFMzkxODk4RDkwQkY4Q0U0NzYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5WHowqAAAXNElEQVR42uxda4xd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";const I={class:"home"};function v(e,t,o,r,a,l){const n=(0,s.g2)("HelloWorld");return(0,s.uX)(),(0,s.CE)("div",I,[t[0]||(t[0]=(0,s.Lk)("img",{alt:"Vue logo",src:k},null,-1)),(0,s.bF)(n,{msg:"Welcome to Your Vue.js App"})])}const y={getPersons(){return d.A.get("http://127.0.0.1:8000/api/people")}};var N=y,w={data(){return{persons:[]}},mounted(){N.getPersons().then((e=>{console.log(e.data),this.persons=e.data.member})).catch((e=>{console.error("Erreur lors de la récupération des données:",e)}))}};const L=(0,g.A)(w,[["render",v]]);var C=L;const R={class:"register container border p-4"},E={class:"col-12"},S={class:"col-md-6"},W={class:"col-md-6"},A={class:"col-md-6"},U={class:"col-md-6"},V={class:"col-md-6"},Q={class:"col-md-6"},P={class:"col-md-6"},Z={class:"col-md-6"},G={class:"col-12"},B=["disabled"],z={class:"col-12"};function J(e,t,o,l,n,i){return(0,s.uX)(),(0,s.CE)("div",R,[t[19]||(t[19]=(0,s.Lk)("h1",{class:"text-center mb-4"},"Inscription",-1)),(0,s.Lk)("form",{onSubmit:t[9]||(t[9]=(0,r.D$)(((...e)=>i.registerUser&&i.registerUser(...e)),["prevent"])),class:"row g-3"},[(0,s.Lk)("div",E,[t[10]||(t[10]=(0,s.Lk)("label",{for:"email",class:"form-label mt-3"},"Email",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[0]||(t[0]=e=>n.form.email=e),type:"email",id:"email",class:"form-control",required:""},null,512),[[r.Jo,n.form.email]])]),(0,s.Lk)("div",S,[t[11]||(t[11]=(0,s.Lk)("label",{for:"firstName",class:"form-label mt-3"},"First name",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[1]||(t[1]=e=>n.form.firstName=e),type:"text",id:"firstName",class:"form-control",required:""},null,512),[[r.Jo,n.form.firstName]])]),(0,s.Lk)("div",W,[t[12]||(t[12]=(0,s.Lk)("label",{for:"lastName",class:"form-label mt-3"},"Last name",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[2]||(t[2]=e=>n.form.lastName=e),type:"text",id:"lastName",class:"form-control",required:""},null,512),[[r.Jo,n.form.lastName]])]),(0,s.Lk)("div",A,[t[13]||(t[13]=(0,s.Lk)("label",{for:"streetName",class:"form-label mt-3"},"Street name",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[3]||(t[3]=e=>n.form.streetName=e),type:"text",id:"streetName",class:"form-control",required:""},null,512),[[r.Jo,n.form.streetName]])]),(0,s.Lk)("div",U,[t[14]||(t[14]=(0,s.Lk)("label",{for:"streetNumber",class:"form-label mt-3"},"Number",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[4]||(t[4]=e=>n.form.streetNumber=e),type:"number",id:"streetNumber",class:"form-control",required:""},null,512),[[r.Jo,n.form.streetNumber]])]),(0,s.Lk)("div",V,[t[15]||(t[15]=(0,s.Lk)("label",{for:"city",class:"form-label mt-3"},"Town",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[5]||(t[5]=e=>n.form.city=e),type:"text",id:"city",class:"form-control",required:""},null,512),[[r.Jo,n.form.city]])]),(0,s.Lk)("div",Q,[t[16]||(t[16]=(0,s.Lk)("label",{for:"postalCode",class:"form-label mt-3"},"Zip code",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[6]||(t[6]=e=>n.form.postalCode=e),type:"text",id:"postalCode",class:"form-control",required:""},null,512),[[r.Jo,n.form.postalCode]])]),(0,s.Lk)("div",P,[t[17]||(t[17]=(0,s.Lk)("label",{for:"password",class:"form-label mt-3"},"Password",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[7]||(t[7]=e=>n.form.password=e),type:"password",id:"password",class:"form-control",required:"",autocomplete:"new-password"},null,512),[[r.Jo,n.form.password]])]),(0,s.Lk)("div",Z,[t[18]||(t[18]=(0,s.Lk)("label",{for:"confirmPassword",class:"form-label mt-3"},"Confirm Password",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[8]||(t[8]=e=>n.form.confirmPassword=e),type:"password",id:"confirmPassword",class:"form-control",required:"",autocomplete:"new-password"},null,512),[[r.Jo,n.form.confirmPassword]])]),(0,s.Lk)("div",G,[(0,s.Lk)("button",{disabled:n.loading,type:"submit",class:"btn btn-primary w-80 mt-4 mx-auto d-block"},"Subscribe",8,B)]),(0,s.Lk)("div",z,[n.errorMessage?((0,s.uX)(),(0,s.CE)("p",{key:0,class:(0,a.C4)({"text-danger":!n.isSuccess,"text-success":n.isSuccess})},(0,a.v_)(n.errorMessage),3)):(0,s.Q3)("",!0)])],32)])}o(4114);var x={data(){return{form:{email:"",adress:"",password:"",confirmPassword:""},errorMessage:"",isSuccess:!1,loading:!1}},methods:{async registerUser(){if(this.form.password!==this.form.confirmPassword)return this.errorMessage="Passwords must match.",void(this.isSuccess=!1);this.loading=!0;try{const e=await fetch("http://localhost:8000/api/register-user",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({email:this.form.email,firstName:this.form.firstName,lastName:this.form.lastName,streetName:this.form.streetName,streetNumber:this.form.streetNumber,city:this.form.city,postalCode:this.form.postalCode,password:this.form.password})}),t=await e.json();e.ok?(this.errorMessage=t.message,this.isSuccess=!0,setTimeout((()=>{this.$router.push("/")}),1500)):(this.errorMessage=t.message||"An error occured.",this.isSuccess=!1)}catch(e){this.errorMessage="Server unreachable, please try later.",this.isSuccess=!1}finally{this.loading=!1}}}};const O=(0,g.A)(x,[["render",J],["__scopeId","data-v-3bf4f600"]]);var M=O;const Y={class:"login container border p-4"},X={class:"col-12"},K={class:"col-12"},j={class:"col-12"},T=["disabled"],F={class:"col-12"},D={key:0,class:(0,a.C4)({"text-danger":!0})};function H(e,t,o,l,n,i){return(0,s.uX)(),(0,s.CE)("div",Y,[t[5]||(t[5]=(0,s.Lk)("h1",{class:"text-center mb-4"},"Login",-1)),(0,s.Lk)("form",{onSubmit:t[2]||(t[2]=(0,r.D$)(((...e)=>l.handleLogin&&l.handleLogin(...e)),["prevent"])),class:"row g-3"},[(0,s.Lk)("div",X,[t[3]||(t[3]=(0,s.Lk)("label",{for:"email",class:"form-label mt-3"},"Email",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[0]||(t[0]=e=>l.email=e),type:"email",id:"email",class:"form-control",required:""},null,512),[[r.Jo,l.email]])]),(0,s.Lk)("div",K,[t[4]||(t[4]=(0,s.Lk)("label",{for:"password",class:"form-label mt-3"},"Password",-1)),(0,s.bo)((0,s.Lk)("input",{"onUpdate:modelValue":t[1]||(t[1]=e=>l.password=e),type:"password",id:"password",class:"form-control",required:""},null,512),[[r.Jo,l.password]])]),(0,s.Lk)("div",j,[(0,s.Lk)("button",{type:"submit",disabled:e.loading,class:"btn btn-primary w-80 mt-4 mx-auto d-block"},"Login",8,T)]),(0,s.Lk)("div",F,[l.errorMessage?((0,s.uX)(),(0,s.CE)("p",D,(0,a.v_)(l.errorMessage),1)):(0,s.Q3)("",!0)])],32)])}var q={setup(){const e=(0,m.KR)(""),t=(0,m.KR)(""),o=(0,m.KR)(""),r=(0,s.WQ)("isLoggedIn");r||console.error("isLoggedIn is not properly injected.");const a=(0,h.rd)(),l=async()=>{try{const o=await d.A.post("http://localhost:8000/api/login",{email:e.value,password:t.value},{withCredentials:!0}),{token:l,user:n}=o.data;localStorage.setItem("token",l),localStorage.setItem("userFirstName",n.first_name),localStorage.setItem("userRoleName",n.role_name);const i=(0,s.WQ)("updateUserInfo");i&&i(),r.value=!0,a.push("/")}catch(l){console.error("Login failed:",l),o.value="Login failed. Please check your credentials."}},n=async()=>{const e=localStorage.getItem("token");if(e)try{await d.A.get("http://localhost:8000/api/check-token",{headers:{Authorization:`Bearer ${e}`}}),r.value=!0}catch(t){console.error("Invalid or expired token:",t),localStorage.removeItem("token"),localStorage.removeItem("user"),r.value=!1}},i=async()=>{try{await d.A.post("http://localhost:8000/api/logout"),localStorage.removeItem("token"),localStorage.removeItem("user"),r.value=!1,alert("Logout successful")}catch(e){console.error("Error during logout:",e)}};return(0,s.sV)(n),(0,s.Gt)("isLoggedIn",r),{email:e,password:t,errorMessage:o,isLoggedIn:r,handleLogin:l,logout:i}}};const _=(0,g.A)(q,[["render",H],["__scopeId","data-v-68315e62"]]);var $=_;const ee=[{path:"/",name:"home",component:C},{path:"/about",name:"about",component:()=>o.e(594).then(o.bind(o,603))},{path:"/register",name:"register",component:M},{path:"/login",name:"login",component:$}],te=(0,h.aE)({history:(0,h.LA)("/dist/"),routes:ee});var oe=te;(0,r.Ef)(b).use(oe).mount("#app")}},t={};function o(r){var s=t[r];if(void 0!==s)return s.exports;var a=t[r]={exports:{}};return e[r].call(a.exports,a,a.exports,o),a.exports}o.m=e,function(){var e=[];o.O=function(t,r,s,a){if(!r){var l=1/0;for(u=0;u<e.length;u++){r=e[u][0],s=e[u][1],a=e[u][2];for(var n=!0,i=0;i<r.length;i++)(!1&a||l>=a)&&Object.keys(o.O).every((function(e){return o.O[e](r[i])}))?r.splice(i--,1):(n=!1,a<l&&(l=a));if(n){e.splice(u--,1);var c=s();void 0!==c&&(t=c)}}return t}a=a||0;for(var u=e.length;u>0&&e[u-1][2]>a;u--)e[u]=e[u-1];e[u]=[r,s,a]}}(),function(){o.d=function(e,t){for(var r in t)o.o(t,r)&&!o.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})}}(),function(){o.f={},o.e=function(e){return Promise.all(Object.keys(o.f).reduce((function(t,r){return o.f[r](e,t),t}),[]))}}(),function(){o.u=function(e){return"js/about.dfeabdc6.js"}}(),function(){o.miniCssF=function(e){}}(),function(){o.g=function(){if("object"===typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"===typeof window)return window}}()}(),function(){o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)}}(),function(){var e={},t="front:";o.l=function(r,s,a,l){if(e[r])e[r].push(s);else{var n,i;if(void 0!==a)for(var c=document.getElementsByTagName("script"),u=0;u<c.length;u++){var m=c[u];if(m.getAttribute("src")==r||m.getAttribute("data-webpack")==t+a){n=m;break}}n||(i=!0,n=document.createElement("script"),n.charset="utf-8",n.timeout=120,o.nc&&n.setAttribute("nonce",o.nc),n.setAttribute("data-webpack",t+a),n.src=r),e[r]=[s];var d=function(t,o){n.onerror=n.onload=null,clearTimeout(f);var s=e[r];if(delete e[r],n.parentNode&&n.parentNode.removeChild(n),s&&s.forEach((function(e){return e(o)})),t)return t(o)},f=setTimeout(d.bind(null,void 0,{type:"timeout",target:n}),12e4);n.onerror=d.bind(null,n.onerror),n.onload=d.bind(null,n.onload),i&&document.head.appendChild(n)}}}(),function(){o.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}}(),function(){o.p="/dist/"}(),function(){var e={524:0};o.f.j=function(t,r){var s=o.o(e,t)?e[t]:void 0;if(0!==s)if(s)r.push(s[2]);else{var a=new Promise((function(o,r){s=e[t]=[o,r]}));r.push(s[2]=a);var l=o.p+o.u(t),n=new Error,i=function(r){if(o.o(e,t)&&(s=e[t],0!==s&&(e[t]=void 0),s)){var a=r&&("load"===r.type?"missing":r.type),l=r&&r.target&&r.target.src;n.message="Loading chunk "+t+" failed.\n("+a+": "+l+")",n.name="ChunkLoadError",n.type=a,n.request=l,s[1](n)}};o.l(l,i,"chunk-"+t,t)}},o.O.j=function(t){return 0===e[t]};var t=function(t,r){var s,a,l=r[0],n=r[1],i=r[2],c=0;if(l.some((function(t){return 0!==e[t]}))){for(s in n)o.o(n,s)&&(o.m[s]=n[s]);if(i)var u=i(o)}for(t&&t(r);c<l.length;c++)a=l[c],o.o(e,a)&&e[a]&&e[a][0](),e[a]=0;return o.O(u)},r=self["webpackChunkfront"]=self["webpackChunkfront"]||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))}();var r=o.O(void 0,[504],(function(){return o(726)}));r=o.O(r)})();