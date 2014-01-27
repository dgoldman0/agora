var Model = new Object();
function MenuItem(link, text)
{
	this.link = link;
	this.text = text;
}
function Article(title)
{
	this.title = title;
}
Mode.articles = new Array();
Model.populateArticles = function()
{

}
Model.init = function()
{	
	$( document ).ready(View.generateFromModel());
	Main.populateArticles();
}
Model.getPrimaryNavigation = function()
{
	var nav = new Object();
	nav.root = '/index.html';
	nav.brand = 'Agora';
	nav.getPrimaryItems = function()
	{
		var menuitems = new Array();
		menuitems.push(new MenuItem('about.html','About'));
                menuitems.push(new MenuItem('market.html','Market'));
                menuitems.push(new MenuItem('stream.html','Stream'));
		return menuitems;
	}
	nav.getSecondaryItems = function()
	{
                var menuitems = new Array();
                menuitems.push(new MenuItem('profile.html','Profile'));
                menuitems.push(new MenuItem('settings.html','Settings'));
                menuitems.push(new MenuItem('#','Logout'));
		return menuitems;
	}
	return nav;
}

var View = new Object();
View.generatePrimaryNavigation = function()
{
	navigation = Model.getPrimaryNavigation();
	var navcode = '<nav class="navbar navbar-default" role="navigation"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle"collapse" data-taget="#bs-example-navbar-collapse-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="' + navigation.root + '">' + navigation.brand + '</a></div><div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"><ul class="nav navbar-nav">';
	navigation.getPrimaryItems().forEach(function(item)
	{
		navcode += '<li class="active"><a href="' + item.link + '">' + item.text + '</a></li>';
	});
	navcode += '</ul><ul class="nav navbar-nav navbar-right">';
	navigation.getSecondaryItems().forEach(function(item)
	{
		navcode += '<li><a href="' + item.link + '">' + item.text + '</a></li>';
        });
        navcode += '</ul>';
	navcode += '</div></nav>';
	$( '#main' ).append(navcode);
}
View.generateArticle = function(article)
{
	var code = '<article id="article-block"><div class="jumbotron"><h1>' + article.title + '</h1></div></article>';
	View.articles[article] = $.parseHTML(code);
}
View.setArticleToActive = function(article)
{
	$( '#article-block' ).replaceWith(View.articles[article];
}
View.generateFromModel = function()
{
	View.generatePrimaryNavigation();
	$( '#main' ).append('<article id="article-block"></article>');
}
