<!-- script src="{ { asset('js/app.js') }}"></script -->

    <script src="https://unpkg.com/vue@2.0.3/dist/vue.js"></script>

    <script>

var app = new Vue({
        el: '#app',
        data: {
            message: 'WOWOOWOWOW',
            intro: 'Welcome <h1>introduction</h1>',
            showz: false,
            zhow: false,
            panel: 'POSITION',

            logical: true,
            tooltip: 'boo ya!',
            todos: [
                {text:'learn vue', id: 1},
                {text:'write processes', id: 2},
                {text:'meditate', id: 3}
            ]
        }
    })
    </script>
