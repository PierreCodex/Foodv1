const listItem = document.getElementsByClassName('listItem')
console.log(listItem);

for(let i=0; i<listItem.length; i++){
    listItem[i].addEventListener('click', function(){
        for(let a=0; a<listItem.length; a++){
            listItem[a].classList.remove('active')
        }
        this.classList.add('active')
 
    })
}