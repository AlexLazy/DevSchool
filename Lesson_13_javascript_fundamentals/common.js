function one()
{
    var name = 'Алексей', age = 29;
    
    console.log('Меня зовут '+name);
    console.log('Мне '+age+'лет');
    delete name, age;
}

function two()
{
//    var CITY = 'Dzerzhinsk'
    const CITY = 'Dzerzhinsk';//Поддерживается не везде http://kangax.github.io/compat-table/es6/
    if(CITY != null) console.log(CITY);
//    const CITY = 'Moscow';
}

function three()
{
    var book = {
        title: 'JAVA',
        author: 'Mett',
        pages: 200
    };
    console.log('Недавно я прочитал книгу '+book.title+', написанную автором '+book.author+', я осилил все '+book.pages+' страниц, мне она очень понравилась.');
}

function four()
{
    var book1 = {
        title: 'JAVA',
        author: 'Mett',
        pages: 200
    };
    
    var book2 = {
        title: 'JavaScript',
        author: 'Tom',
        pages: 100
    };
    
    var books = {
        book1: book1,
        book2: book2
    };
    console.log('Недавно я прочитал книги '+books.book1.title+' и '+books.book2.title+', написанные соответственно авторами '+books.book1.author+' и '+books.book2.author+
            ', я осилил в сумме '+(books.book1.pages+books.book2.pages)+' страниц, не ожидал от себя подобного.');
}
one(), two(), three(), four();