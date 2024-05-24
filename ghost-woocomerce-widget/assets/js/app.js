jQuery(document).ready(function(){
    // price separator ","
    let prices = document.querySelectorAll(".price")
    prices.forEach(el => {
        el.innerHTML = priceHtml(el.innerText)
    })
    //persian numbers
    let persian_numbers = document.querySelectorAll(".container *")
    persian_numbers.forEach(function (e){
        traverse(e)
    })


    // all products
    let products = document.querySelectorAll(".section-2 .item")

    // tags
    let tags = document.querySelectorAll(".section-4 .g-block")

    // category filters
    let filter_cats = document.querySelectorAll(".filter-item")

    // mobile navs section
    let product_nav = document.querySelector(".nav-1")
    let tag_nav = document.querySelector(".nav-2")

    let active_filter = document.querySelector(".filter-item.active").getAttribute("filter")
    products.forEach(function(e){
        if(e.getAttribute("cat") != active_filter){
            hideItem(e)
        }
    })

    filter_cats.forEach(function(e){
        e.addEventListener("click", function(){
            let clicked_filter = e.getAttribute("filter")
            resetFilter(filter_cats)
            activateFilter(e)
            products.forEach(function(b){
                b.classList.remove("hidden")
                if(b.getAttribute("cat") != clicked_filter){
                    hideItem(b)
                }
            })
            product_nav.innerHTML = dotGenerator(".section-2 .item","id")
            navs = document.querySelectorAll('.nav-1 div');
            navigator(navs,products,'id')
        })
    })

    // initialize navs
    product_nav.innerHTML = dotGenerator(".section-2 .item","id")
    let navs = document.querySelectorAll(".nav-1 div")
    navigator(navs,products,'id')

    tag_nav.innerHTML = dotGenerator(".section-4 .g-block","tag_id")
    let navs_2 = document.querySelectorAll(".nav-2 div")
    navigator(navs_2,tags,'tag_id')
})

// persian numbers
persian={0:'۰',1:'۱',2:'۲',3:'۳',4:'۴',5:'۵',6:'۶',7:'۷',8:'۸',9:'۹'};
function traverse(element){
    if(element.nodeType==3){
        var list=element.data.match(/[0-9]/g);
        if(list!=null && list.length!=0){
            for(var i=0;i<list.length;i++)
                element.data=element.data.replace(list[i],persian[list[i]]);
        }
    }
    for(var i=0;i<element.childNodes.length;i++){
        traverse(element.childNodes[i]);
    }
}

function hideItem(e){
    e.classList.add("hidden")
}

function activateFilter(e){
    e.classList.add("active")
}

function resetFilter(filters){
    filters.forEach(function(e){
        e.classList.remove("active")
    })
}

function resetItemsVisibility(items){
    items.forEach(function(e){
        e.classList.remove("hidden")
    })
}

function dotGenerator(query,identifier){
    let new_items = document.querySelectorAll(query)
    let active_items = []
    new_items.forEach(el => {
        if(!el.classList.contains('hidden')){
            active_items.push(el.getAttribute(identifier))
        }
    })
    let dots = ""
    let i = 0
    active_items.forEach(e =>{
        if(i == 0){
            dots += "<div class='active' nav='" + e + "'></div>"
        }else{
            dots += "<div nav='" + e + "'></div>"
        }
        i++
    })
    return dots
}

function navigator(navs,items,id_name){
    navs.forEach(function(e){
        e.addEventListener("click", function(){
            resetItemsVisibility(items)
            let clicked_filter = e.getAttribute("nav")
            resetNavs(navs)
            e.classList.add("active")
            items.forEach(function(b){
                if(b.getAttribute(id_name) != clicked_filter){
                    hideItem(b)
                }
            })
        })
    })
}

function resetNavs(navs){
    navs.forEach(function(e){
        e.classList.remove("active")
    })
}

function priceHtml(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
