/* 
  ------------------------------------------------
  TabBar Magic menu scripts
  Copyright (c) 2005-2006 Project Seven Development
  www.projectseven.com
  Version: 1.0.2 
  ------------------------------------------------
*/

var p7tbma=new Array();
var p7tbmt=new Array();

function P7_initTBM(){ //v1.0.2 by PVII-www.projectseven.com
 //define over and down image suffix
 var Iv = "_f2";
 var Id = "_f3";
 var i,j,x,k,d,nV,tB,tbs,iM,im,ts,tA,sA,nA=new Array();
 document.p7tbmsw=new Array();p7tbma=arguments;
 if(!document.getElementById||document.p7tbmf){return;}
 tb=document.getElementById('p7TBM');if(!tb){return;}tb.onmouseout=P7_TBMclose;
 tB=document.getElementById('p7TBM');nV=document.getElementById('p7TBMroot');
 if(!nV||!tB){return;}tA=nV.getElementsByTagName('A');j=0;for(i=0;i<tA.length;i++){
 p7tbmt[j]=tA[i].id;j++;d='p7TBMsub'+tA[i].id.replace('p7TBMt','');
 tbs=document.getElementById(d);if(tbs){tbs.onmouseover=function(){P7_TBMsub(this);};}
 p7tbmt[j]=(tbs)?tbs.id:false;tA[i].hasSub=p7tbmt[j];j++;tA[i].isRoot=true;
 tA[i].onclick=function(){return P7_TBMtrig(this);};
 tA[i].onmouseover=function(){P7_TBMovr(this);};tA[i].p7state=0;tA[i].hasIm=false;
 iM=tA[i].getElementsByTagName('IMG');if(iM&&iM[0]){im=iM[0];ts=im.getAttribute("src");
 x=ts.lastIndexOf(".");nA[0]=ts.substring(0,x);nA[1]='.'+ts.substring(x+1);
 im.p7mimg=new Array();im.p7mimg[0]=ts;if(p7tbma[1]>1){ts=nA[0]+Iv+nA[1];
 P7_TBMpl(ts);}im.p7mimg[1]=ts;if(p7tbma[1]==3){im.p7mimg[2]=ts;}
 if(p7tbma[1]==1||p7tbma[1]==2){ts=nA[0]+Id+nA[1];P7_TBMpl(ts);if(p7tbma[1]==1){
 im.p7mimg[1]=ts;}}im.p7mimg[2]=ts;im.p7state=0;tA[i].hasIm=true;}}
 document.p7tbmf=true;P7_TBMopen();
}

function P7_TBMpl(ims){ //v1.0.2 by PVII-www.projectseven.com
 var x=document.p7tbmsw.length;document.p7tbmsw[x]=new Image();document.p7tbmsw[x].src=ims;
}

function P7_TBMovr(a){ //v1.0.2 by PVII-www.projectseven.com
 if(!document.p7tbmf){return;}if(document.p7TBMtm){clearTimeout(document.p7TBMtm);}P7_TBMswp(a);
 if(p7tbma[0]==1){document.p7TBMtm=setTimeout("P7_TBMshow('"+a.id+"')",p7tbma[4]);
 }else{P7_TBMshow(a.id);}}

function P7_TBMswp(d){ //v1.0.2 by PVII-www.projectseven.com
 var i,cl,a;for(i=0;i<p7tbmt.length;i+=2){a=document.getElementById(p7tbmt[i]);
 cl=a.className;if(p7tbmt[i]!=d.id){if(a.p7state<2){if(cl.indexOf("p7TBMon")>-1){
 a.className=cl.replace("p7TBMon",'');}if(a.hasIm){im=a.getElementsByTagName('IMG')[0];
 if(im.p7state<2){im.src=im.p7mimg[0];}}}}else{if(a.p7state!=2){if(cl.indexOf("p7TBMon")==-1){
 a.className=(cl&&cl.length>0)?cl+" p7TBMon":"p7TBMon";}if(a.hasIm){
 im=a.getElementsByTagName('IMG')[0];if(im.p7state<2){im.src=im.p7mimg[1];}}}}}
}

function P7_TBMshow(d){ //v1.0.2 by PVII-www.projectseven.com
 var a,i,im,cl;a=document.getElementById(d);if(a.hasIm){im=a.getElementsByTagName('IMG')[0];
 if(im.p7state==0){im.src=im.p7mimg[1];im.p7state=1;}}if(a.hasSub){if(a.p7state!=2){
 a.p7state=1;cl=a.className;if(cl.indexOf("p7TBMon")==-1){
 a.className=(cl&&cl.length>0)?cl+" p7TBMon":"p7TBMon";}}
 document.getElementById(a.hasSub).style.visibility="visible";P7_TBMtg(a);}
}

function P7_TBMtg(d){ //v1.0.2 by PVII-www.projectseven.com
 var i,im,s,cl;for(i=0;i<p7tbmt.length;i+=2){if(!d||p7tbmt[i]!=d.id){
 a=document.getElementById(p7tbmt[i]);if(a.hasIm){im=a.getElementsByTagName('IMG')[0];
 if(im.p7state<2){im.src=im.p7mimg[0];im.p7state=0;}}if(a.p7state!=2){a.p7state=0;
 cl=a.className;if(cl.indexOf("p7TBMon")>-1){a.className=cl.replace("p7TBMon",'');}}
 s=document.getElementById(p7tbmt[i+1]);if(s){s.style.visibility="hidden";}}}
}

function P7_TBMtrig(a){ //v1.0.2 by PVII-www.projectseven.com
 var h,hh,ret=false;P7_TBMdown(a);h=a.href;hh='javascript:; javascript:void(0)';
 if(p7tbma[3]==1){if(h.charAt(h.length-1)=='#'||document.location.href==h){
 ret=false;}else{ret=(hh.indexOf(h)>-1)?false:true;}}else{ret=false;}return ret;
}

function P7_TBMdown(a){ //v1.0.2 by PVII-www.projectseven.com
 var i,aa,im,cl;for(i=0;i<p7tbmt.length;i+=2){aa=document.getElementById(p7tbmt[i]);
 aa.p7state=0;aa.className=P7_trim(aa.className.replace("p7TBMdown",''));if(aa.hasIm){
 im=aa.getElementsByTagName('IMG')[0];im.p7state=0;}}a.p7state=2;if(a.hasIm){
 im=a.getElementsByTagName('IMG')[0];im.p7state=2;im.src=im.p7mimg[2];}else{cl=a.className;
 a.className=(cl&&cl.length>0)?cl+" p7TBMdown":"p7TBMdown";}P7_TBMshow(a.id);
}
function P7_trim(t){ //v1.0.2 by PVII-www.projectseven.com
 t=t.replace(/^\s/,'');t=t.replace(/\s$/,'');return t;
}

function P7_TBMclose(evt){ //v1.0.2 by PVII-www.projectseven.com
 var i,pp,tS,d,p,f,m=true;evt=(evt)?evt:((event)?event:null);if(evt){
 tS=(evt.relatedTarget)?evt.relatedTarget:evt.toElement;if(tS){pp=tS;
 while(pp){if(pp.id){d=pp.id;if(pp.id.indexOf("p7TBM")>-1){m=false;break;}}
 pp=pp.parentNode;}if(m){f='P7_TBMtg()';if(p7tbma[2]==1){for(i=0;i<p7tbmt.length;i+=2){
 p=document.getElementById(p7tbmt[i]);if(p.p7state==2){f="P7_TBMshow('"+p.id+"')";}}}
 if(p7tbma[0]==1){eval('document.p7TBMtm=setTimeout("'+f+'",'+parseInt(p7tbma[4]+50)+')');
 }else{eval(f);}}}}
}

function P7_TBMsub(s){ //v1.0.2 by PVII-www.projectseven.com
 if(document.p7TBMtm){clearTimeout(document.p7TBMtm);}
 var d=s.id.replace("p7TBMsub","p7TBMt"),a=document.getElementById(d);
 P7_TBMswp(a);
}

function P7_TBMmark(){document.p7TBMop=arguments;}

function P7_TBMopen(){ //v1.0.2 by PVII-www.projectseven.com
 var x,i,j,k,kk,wH,tM,tA,pp,cl,a,nd,op,r1,aU;wH=window.location.href;
 var mt = new Array(1,'','');if(document.p7TBMop){mt=document.p7TBMop;}op=mt[0];
 if(op<1){return;}r1=/index\.[\S]*/i;k=-1,kk=-1;tM=document.getElementById('p7TBM');
 tA=tM.getElementsByTagName("A");for(j=0;j<tA.length;j++){aU=tA[j].href.replace(r1,'');
 if(op>0){if(tA[j].href==wH||aU==wH){k=j;kk=-1;break;}}if(op==2){if(tA[j].firstChild){
 if(tA[j].firstChild.nodeValue==mt[1]){kk=j;}}}if(op==3 && tA[j].href.indexOf(mt[1])>-1){
 kk=j;}if(op==4){for(x=1;x<mt.length;x+=2){if(wH.indexOf(mt[x])>-1){
 if(tA[j].firstChild&&tA[j].firstChild.nodeValue){if(tA[j].firstChild.nodeValue==mt[x+1]){
 kk=j;}}}}}}k=(kk>k)?kk:k;if(k>-1){a=false;if(!tA[k].hasIm&&!tA[k].isRoot){cl=tA[k].className;
 tA[k].className=(cl&&cl.length>0)?cl+" p7TBMmark":"p7TBMmark";}pp=tA[k].parentNode;
 while(pp){if(pp.id&&pp.id=='p7TBMroot'){a=tA[k];break;}if(pp.id&&pp.id.indexOf('p7TBMsub')>-1){
 nd='p7TBMt'+pp.id.replace('p7TBMsub','');a=document.getElementById(nd);break;}
 pp=pp.parentNode;}if(a){P7_TBMdown(a);}}
}

