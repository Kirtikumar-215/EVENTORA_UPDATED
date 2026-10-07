document.addEventListener('DOMContentLoaded',()=>{
 document.querySelectorAll('[data-countdown]').forEach(el=>{
  const target=new Date(el.dataset.countdown).getTime();
  const tick=()=>{let d=Math.max(0,target-Date.now());const days=Math.floor(d/86400000);d%=86400000;const hrs=Math.floor(d/3600000);d%=3600000;const mins=Math.floor(d/60000);d%=60000;const secs=Math.floor(d/1000);['days','hours','minutes','seconds'].forEach((k,i)=>{const n=[days,hrs,mins,secs][i];const node=el.querySelector(`[data-unit="${k}"]`);if(node)node.textContent=String(n).padStart(2,'0')});};tick();setInterval(tick,1000);
 });
 document.querySelectorAll('[data-auto-dismiss]').forEach(e=>setTimeout(()=>e.remove(),4500));
 document.querySelectorAll('.needs-confirm').forEach(form=>form.addEventListener('submit',e=>{if(!confirm(form.dataset.confirm||'Are you sure?'))e.preventDefault()}));
});
