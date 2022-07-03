function mauvaisNomDeDomaine(){
    if(location.host !== "tutopy.com" && location.host !== "www.tutopy.com"){
        document.querySelector("html").remove();
    }
};
mauvaisNomDeDomaine();

function mauvaisProtocol(){
    if(location.protocol !== "https:"){
        location.protocol="https:";
    }
};
mauvaisProtocol();