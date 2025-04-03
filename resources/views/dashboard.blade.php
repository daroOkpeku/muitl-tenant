<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-6/iCBmLmgmEsn0mYSsTH4kJK6xtpzawVxCfaOj04Nsukkzvk3ccG6AS2oC1pilRFNtvzYZvv9mXVc49SuQi1dA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    @include('layout.head') 
   
{{--     <a href="{{ url('api/v1/reportall') . '?' . http_build_query(['reportType' =>request()->get('reportType'), 'userid' => $user->id,  'period'=>request()->get('period'), 'type'=>request()->get('type'), 'country_name'=>request()->get('country_name')]) }}"
        > --}}
<body>
<div >
     @include('layout.nav')
      <div class="create-blog content ">
    

        @if (session('error'))
        <p style="text-align: center; display: flex; justify-content: center; align-items: center; color:red;">
            {{ session('error') }} 
        </p>
        @endif
        
         <div class="searchbar">
            <section class="searchbar_first">
                <input type=""  name="search" value="{{ request()->get('search') }}" class="search_text" placeholder="" />
                
            </section>
            <section class="searchbar_second">
                <button type="submit" style="background:gray; " class="search_x" >search</button>
            </section>
         </div>
      
        <div class="table-cover">
            <table>
             <thead>
               <tr>
                <th>Name</th>
                <th>email</th>
                <th>user type</th>
                <th>Approve status</th>
                <th>action</th>
               </tr>
             </thead>

             <tbody>
                @foreach ($users as $user)
                <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if ($user->is_admin == 1)
                      Admin
                    @else
                    User     
                    @endif
                </td>
                <td>
                    @if ($user->is_approve == 1)
                    Approve
                  @else
                  Disapprove     
                  @endif
                </td>
                <td>
                    @if ($user->is_approve == 1)
                    <a href="{{ url('approve') . '?' . http_build_query(['is_approve' =>0, 'id' => $user->id ]) }} ">   <button class="approve" style="background:red;  align-items: center;  justify-items: center;" >
                     Disapprove
                  </button></a>
                  @else
                  <a href="{{ url('approve') . '?' . http_build_query(['is_approve' =>1, 'id' => $user->id ]) }} ">   <button class="approve" style="background:green;  align-items: center;  justify-items: center;" >
                    Approve
                 </button></a>
                    @endif
                   
                </td>  
                </tr>
                @endforeach
               
             </tbody>

            </table>
        
        </div>

        {{ $users->links() }}
      
     @include('layout.footer')

    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.9/dist/axios.min.js"></script>
<script>


// {{ route('dashboard') }}
const submitRemarkBtn = document.querySelector('.search_x');
const scrutinyRemark = document.querySelector('.search_text');
submitRemarkBtn.addEventListener('click', function(e) {
            e.preventDefault();
            submitRemarkBtn.innerText = 'Please wait...';

            let csrfToken = @json(csrf_token());
            // 
            let url = "{{ route('dashboard') }}?search=${scrutinyRemark.value}";

            // let formData = new FormData();
            // formData.append('search', scrutinyRemark.value);
            let headers = {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            };
            axios.get(url, headers)
                .then(res => {
                    console.log(res);
                    submitRemarkBtn.innerText = 'search';

                    
                        setTimeout(() => {
                            window.location.href = `{{ route('dashboard') }}?search=${scrutinyRemark.value}`;
                        }, 1000);
                       })
                .catch(error => {
                    console.error('Request failed', error);
                    submitRemarkBtn.innerText = 'search';
                });
        });
</script>
</html>