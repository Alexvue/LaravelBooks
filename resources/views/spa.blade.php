<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <!-- Подключаем Bootstrap, чтобы не работать над дизайном проекта -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    @verbatim
    <div id="app">
        <div class="container mt-5">
            <h1>Список книг нашей библиотеки</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Автор</th>
                        <th scope="col">Наличие</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="book in books">
                        <th scope="row">{{book.id}}</th>
                        <td>{{book.title}}</td>
                        <td>{{book.author}}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary" @click="changeBookAvailability(book.id)">
                                Доступна
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-danger" @click="deleteBook(book.id)">
                                Удалить
                            </button>
                        </td>
                    </tr>

                    <!-- Строка с полями для добавления новой книги -->
                    <tr>
                        <th scope="row">Добавить</th>
                        <td><input v-model="addingTitle" type="text" class="form-control"></td>
                        <td><input v-model="addingAuthor" type="text" class="form-control"></td>
                        <td></td>
                        <td>
                            <button type="button" class="btn btn-outline-success" @click="addBook()">
                                Добавить
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endverbatim

    <!--Подключаем axios для выполнения запросов к api -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

    <!--Подключаем Vue.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script>

    <script>
        let vm = new Vue({
            el: '#app',
            data: {
                addingTitle: '',
                addingAuthor: '',
                books: [],
            },
            methods: {
                loadBookList(){
                    axios.get('/book/all').then(response=>{
                        this.books = response.data;
                        console.log(response);
                    })
                },
                addBook(){
                    alert("adding book");
                    axios.post('/book/add', {
                        title: this.addingTitle,
                        author: this.addingAuthor
                    })
                    this.loadBookList();    
                    this.addingTitle = '';
                    this.addingAuthor = '';
                },
                deleteBook(id){
                    axios.get(`/book/delete/${id}`)
                    this.loadBookList();
                },
                changeBookAvailability(id){
                    axios.get(`/book/change_availabilty/${id}`)
                    this.loadBookList();
                },
            },
            mounted(){
                // Сразу после загрузки страницы подгружаем список книг и отображаем его
                this.loadBookList();
            }
        });
    </script>
</body>
</html>