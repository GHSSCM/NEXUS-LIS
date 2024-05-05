window.reloadComps = ()=>{
    setTimeout(function(){
        console.log("RELOADING COMPONENTS");
        var singlefields = document.querySelectorAll( '.single-select-field' );
        for(var i=0;i<singlefields.length;i++){
            $(singlefields[i]).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } )
        }
    
    
        var singlefieldstags = document.querySelectorAll( '.single-select-field-tags' );
        for(var i=0;i<singlefieldstags.length;i++){
            $(singlefieldstags[i]).select2( {
                tags:true,
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } )
        }
    
        
        var singlefieldstags = document.querySelectorAll( '.multiple-select-field' );
        for(var i=0;i<singlefieldstags.length;i++){
            $(singlefieldstags[i]).select2( {
                tags:true,
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
            } )
        }
    
    
    },1000);
}

// $(document).ready(function(){

//       // Select the target node (in this case, the body)
//   const targetNode = document.body;

//   // Options for the observer (which mutations to observe)
//   const config = { attributes: false, childList: true, subtree: true };
  
//   // Callback function to execute when mutations are observed
//   const callback = function(mutationsList, observer) {
//     // console.log("observing...");
    
//       for(const mutation of mutationsList) {
//           if (mutation.type === 'childList') {
//               mutation.addedNodes.forEach(node => {
//                 //   if (node.classList && node.classList.contains('single-select-field')) {
//                       // Do something with the new element here
//                       console.log('New element with class "single-select-field" added:', node.classList);
//                 //   }
//               });
//           }
//       }
//   };
  
//   // Create a new observer instance
//   const observer = new MutationObserver(callback);
  
//   // Start observing the target node for configured mutations
//   observer.observe(targetNode, config);
  
//   console.log("ready");
  
  
  
// });