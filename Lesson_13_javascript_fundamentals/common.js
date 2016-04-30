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
    console.log('Недавно я прочитал книгу '+book.title+', написанную автором '+
            book.author+', я осилил все '+book.pages+
            ' страниц, мне она очень понравилась.');
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
        book2: book2,
        display: function()
        {
            console.log('Недавно я прочитал книги '+this.book1.title+' и '+
                    this.book2.title+', написанные соответственно авторами '+
                    this.book1.author+' и '+this.book2.author+
            ', я осилил в сумме '+(this.book1.pages+this.book2.pages)+
            ' страниц, не ожидал от себя подобного.');
        }
    };
    return books.display();
}
one(), two(), three(), four();