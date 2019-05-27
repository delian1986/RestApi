const HOST='http://localhost';


function attachEvents() {
    $("#all").on('click',showAll);
}

function showAll() {
    $.ajax({
        type: 'GET',
        url: HOST+"/rest/article",
        success: function getAllArticles(response) {
            getArticles(response);
        }
    });
}

function getArticles(response) {
    console.log(response[1].title);
}
