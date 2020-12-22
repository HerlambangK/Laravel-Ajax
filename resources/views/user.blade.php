<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <div id="app">
        <form>
            <input   type="text" name="name" v-model="form.name" >
            <button @click.prevent="add_button" v-show="!updateSubmit"  >Add</button>
            <button @click.prevent="update" v-show="updateSubmit">Update</button>
        </form>
      <ul v-for="(user, index) in users" >
        <li>@{{ user.name }}
            <button @click.prevent="Edit_nama(user,index)"  >Edit</button>
            ||
            <button  @click.prevent="hapus(user,index)">Delete</button>
      </ul>
        </li>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
    <script>
      var app = new Vue({
        el: "#app",
        data() {
          return {
            users: [],
            
            updateSubmit:false,
            form:{
                'name' : ''
            },

            UserId:null,

          };
        },
        mounted() {
            this.getName();
            this.add_button();
            this.Edit_nama()
            this.update();
          },
        methods: {
          getName(){
            this.$http.get('/api/user').then(response => {
            let data = response.body.data;
            console.log(response.body.data);
            this.users = data
            });
          },

          async add_button(){
                try{
                    let response =await axios.post('/api/user', this.form)
                    if(response.status == 200){
                        console.log(response.data);
                        
                        this.form={}
                    }
            }
            catch(e){
                this.theErrors = e.response.data.errors;
                                
            }
          },

          async hapus(index){
              // console.log(index.id);
            let q = window.confirm("Are You Sure deleted ??" ) 
            if( q == true){
                // console.log(this.index);
                    let response = await axios.delete(`/api/user/delete/${index.id}`)
                    console.log(response.data);
                        if(response.status == 200){
                            console.log(response.data);
                    }
            } 
            },

        Edit_nama(user, index){

                      this.UserId =index
                      this.updateSubmit = true
                      this.form.name = user.name
                      console.log(UserId);
                 
                  },
      
          async update(){

          //  this.form['name'];
            console.log(this.UserId);
            console.log(this.form['name']);
            this.users[this.UserId].name =this.form.name
              console.log(this.users[this.UserId].name);
            let response =await axios.patch(`/api/user-edit/${this.users[this.UserId].name}`, this.form.name)
            if(response.status == 200){
                // console.log(response.data);
                   console.log(response.data.body);
            
            }
              this.form=""
                this.updateSubmit=false
                this.UserId=null
      }}
            
        
      });
    </script>
  </body>
</html>
