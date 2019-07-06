<?php


namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Grievance;
use App\report;
use App\user;
use Mail\news;
use App\categories;
use App;
use Mail;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\notification; 
use Mekras\Speller\Hunspell\Hunspell;
// use GenericSpellChecker;

use Mekras\Speller\ExternalSpeller;
use Mekras\Speller\Source\StringSource;
// use Illuminate\Support\Facades\GreivancesExport;

use App\Exports\GreivancesExport;

use App\Exports\GenericSpellChecker\PspellSpellChecker;
// use SpellChecker;
class GrievanceController extends Controller

{
    protected $adminEmail='2017.abhay.tiwari@ves.ac.in';
   

    public function addMember(){
$id=Auth::id();

if($id==null)
    return back();
else $u=User::find($id);
    if($u->role!=0)
        return back();


        return view('admin.addMember');
    }

    public function addMemberBtn(){
       
        $n=7;
        $pw=0;
        $num_str = sprintf("%06d", mt_rand(1, 999999));
        while($n>0){
            
            $p=mt_rand(1, 9);
            $q=mt_rand(1, 9);
            $r=$p*$q;
            $r=$r*$r*($p+$q);
            $pw=($pw*10)+$p+$q+$r;
            $n=$n-1;
        }
        
        $pw=(string)$pw;

        if(isset($_POST['submit'])){
            if($_POST['submit']=='asCategory'){

               $this->validate(request(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users' ,'regex:/[a-zA-Z0-9\.]+@ves.ac.in/u'],
                    'surname'=>['required', 'string', 'max:255'],
                    'category'=>['required'],
                    'staffID'=>['required','integer']
                   
                ]);

                //into user db
              $user=  User::where('class',$_POST['category'])->get();
              if(count($user)==0){
                  //new user entry
                
                  User::create([
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'surname' => $_POST['surname'],
                    'class' => $_POST['category'],
                    'roll_no' => $_POST['staffID'],
                    'password' => Hash::make($pw),
                    'role' =>1
                ]);

              }
              else{
                User::where('class',$_POST['category'])->update([
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'surname' => $_POST['surname'],
                    'class' => $_POST['category'],
                    'roll_no' => $_POST['staffID'],
                    'password' => Hash::make($pw),
                    'role' =>1
                ]);
              }



                //into category table
                    $a=11;  //random number
                switch($_POST['category']){
                    case 'Academics':
                            $a="1";
                            
                            break;
                    
                    case 'Cleanliness':
                            $a="2";
                            break;
                     case 'Infrastructure':
                            $a="3";
                            break;
                     case 'Harassment':
                            $a="4";
                            break;
                     case 'Disciplinary Action':
                            $a="5";
                            break;
                    case 'SC/ST related issue':
                            $a="6";
                            break;       
                    }



//                     INSERT INTO table (id, name, age) VALUES(1, "A", 19) ON DUPLICATE KEY UPDATE    
// name="A", age=19

                    


                  $cat=categories::find($a);
                 if($cat==null){
                     //new entry

                     categories::create([
                         'category'=>$a,
                         'user'=> $_POST['email']
                     ]);
                 }
                 else{
                     
                     categories::where('category',$a)->update([
                         'user'=> $_POST['email']
                     ]);
                 }
                        

                        //mail to cat for password

                        $data=array('pw'=>$pw);
        
        Mail::send('email.mail' ,$data, function($message) use ($pw) {
            $message->to($_POST['email'])->subject
               ('Password for Grievance Log in');
            $message->from('hjminves@gmail.com','Grievance Cell VESIT');
         });
        
       return back()->withErrors('Email sent');
      


            }
            else if($_POST['submit']=='asAdmin'){

                $this->validate(request(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users' ,'regex:/[a-zA-Z0-9\.]+@ves.ac.in/u'],
                    'surname'=>['required', 'string', 'max:255'],
                    'staffID'=>['required','integer']
                   
                ]);

                //user db
                $user=  User::where('class',"Admin")->get();

              if(count($user)==0){
                  //new user entry
                
                  User::create([
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'surname' => $_POST['surname'],
                    'class' => "Admin",
                    'roll_no' => $_POST['staffID'],
                    'password' => Hash::make($pw),
                    'role' =>0
                ]);

              }
              else{
                User::where('class',$_POST['category'])->update([
                    'name' => $_POST['name'],
                    'email' => $_POST['email'],
                    'surname' => $_POST['surname'],
                    'class' => "Admin",
                    'roll_no' => $_POST['staffID'],
                    'password' => Hash::make($pw),
                    'role' =>0
                ]);
              }

               $data=array('pw'=>$pw);
        
        Mail::send('email.mail' ,$data, function($message) use ($pw) {
            $message->to($_POST['email'])->subject
               ('Password for Grievance Log in');
            $message->from('hjminves@gmail.com','Grievance Cell VESIT');
         });
        
       return back()->withErrors('Email sent');








            }

            else return back()->withErrors('Error occurred!');
        }

    }





    public function generateReport(){

      
       
        if(isset($_GET['fromDate']) && isset($_GET['toDate']) ){
           
        }
        $grevs=Grievance::where('status',1)->get();
       
        if(isset($_GET['submit'])){

            if($_GET['fromDate']!="" && $_GET['toDate']!="" && $_GET['category']==0){
                
                $grevs=Grievance::where('created_at','>=',$_GET['fromDate'])->where('status',1)->whereDate('created_at','<=',$_GET['toDate'])->get();

            }
            else if($_GET['fromDate']!="" && $_GET['toDate']==""  && $_GET['category']==0){

                $grevs=Grievance::where('created_at','>=',$_GET['fromDate'])->where('status',1)->get();
            }
            else if($_GET['fromDate']=="" && $_GET['toDate']!=""  && $_GET['category']==0){
                $grevs=Grievance::whereDate('created_at','<=',$_GET['toDate'])->where('status',1)->get();
                
            }

           
            // including category too
            else if ($_GET['fromDate']!="" && $_GET['toDate']!="" && $_GET['category']!=0) {
                 
                $grevs=Grievance::where('created_at','>=',$_GET['fromDate'])->where('status',1)->whereDate('created_at','<=',$_GET['toDate'])->where('category', $_GET['category'])->get();

            }
            else if($_GET['fromDate']!="" && $_GET['toDate']==""  && $_GET['category']!=0){
                $grevs=Grievance::where('created_at','>=',$_GET['fromDate'])->where('status',1)->where('category', $_GET['category'])->get();

            }
            else if($_GET['fromDate']=="" && $_GET['toDate']!=""  && $_GET['category']!=0){

                $grevs=Grievance::whereDate('created_at','<=',$_GET['toDate'])->where('status',1)->where('category', $_GET['category'])->get();
               
            }
            else if ($_GET['fromDate']=="" && $_GET['toDate']=="" && $_GET['category']!=0) {
                 
                $grevs=Grievance::where('category', $_GET['category'])->where('status',1)->get();

            }
            



        }
        $cat=categories::all();
        Session::put('grevReport',$grevs);
        $report=DB::table('reports')->where('status',1)->get();
        Session::put('reports',$report);
        return view('admin.generateReport',compact('grevs','cat','report'));
       
    }

    public function grievancesExport($type){
      
        
        $grevs=Session::get('grevReport');
        $reports=Session::get('reports');
        
        $exporter = app()->makeWith(App\Exports\GrievancesExport::class, compact('grevs','reports'));   
 
        return $exporter->download('Grievance Detail.'.$type);
        // return Excel::download( App\Exports\GrievancesExport::class,'bjhhhrj.xls');
        
    }


    public function showSearchResultAdmin(){

        $q = Input::get ( 'q' );
       
        $grvs = Grievance::where('subject','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%')->orWhere('user_email','LIKE','%'.$q.'%')->get();
        
        return view('admin.searchResults',compact('grvs'))->withQuery ( $q );
        
    }

    public function showSearchResultCM(){
       
        $q = Input::get ( 'q' );
       
        $grvs = Grievance::where('subject','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%')->orWhere('user_email','LIKE','%'.$q.'%')->get();
        
        return view('cm.searchResults',compact('grvs'))->withQuery ( $q );
        
    }
   
    public function changeP()
    {
       
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $id=$user->email;
        $role=$user->role;
        if($role==0)
        return view('admin.change');
        else if($role==1)
        return view('cm.change');
        else if($role==2)
        return view('user.change');
    }

    // public function changeEcell(){
    //     return view('')
    // }


    public function changePassword(Request $request)
    {
        $this->validate(request(),[
            "Password"=>'required',
            "CPassword"=>'required',
        ]);
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $pas1=$request->input('Password');
        $pas2=$request->input('CPassword');
        $role=$user->role;
        if($pas1!=$pas2)
        {
            if($role==0)
            return redirect('/a/change')->with('error','Passwords did not match');
            else if($role==1)
            return redirect('/c/change')->with('error','Passwords did not match');
            else if($role==2)
            return redirect('/u/change')->with('error','Passwords did not match');
        }
        else 
        {

        $pw=Hash::make($pas1);
        $grvs=DB::table('users')
        ->where('id', $id)
        ->update(['password' => $pw]);
        }
        return redirect('/logout');
    }
    
    public function pwd()
    {   
        
        $pw=Session::get('pw');
        $email=Session::get('email');
        $data=array('pw'=>$pw);
        //  Mail::send(['text'=>'mail'], $data, function($message) use ($email,$pw)
        Mail::send('email.mail' ,$data, function($message) use ($email,$pw) {
            $message->to($email)->subject
               ('Password for Grievance Log in');
            $message->from('hjminves@gmail.com','Grievance Cell VESIT');
         });
        // return $pw;
        echo"<script> alert('An Email has been sent successfully');
        window.location.href='logout'; </script>";
      
        
        // return redirect('/logout');

    }

    public function adminRejectMail($gid){

    
        $this->validate(request(),[
            "description"=>'required| max:500'

        ]);



         $adminReply=$_POST['description'];

         //text validate

        //  $source =explode(" ",$adminReply);
        //  $source = new StringSource('Tiger, tigr, burning bright');
        //  $speller = new Hunspell();
        
        // $issues = $speller->checkText($source,['en_GB', 'en_US']);
        // dd($issues);

       

                $grev=Grievance::find($gid);
                $subj=$grev->subject;  
                $cat=$grev->category;
               
                $cat_email=categories::find($cat)->user;
            //   dd("adminRejectMail");
                
               $email="hjminves@gmail.com";
$user_email=$grev->user_email;


            $data=array(
                'email'=>$email,
                'grev'=>$grev,
                'adminReply'=>$adminReply,
                
            );



            if(isset($_POST['submitReject'])){

               $ans= Mail::send('email.adminReportRejectMail' ,$data, function($message) use ($email,$data,$cat_email) {
                    $message->to($cat_email);
                     $message->subject('Report for the grievance rejected.');
                    $message->from($email,'Grievance Cell VESIT');
                 });
        
                 $reports=DB::table('reports')->where('gr_id',$gid)->where('status',0)->orderBy('created_at', 'desc')
                 ->limit(1)->update(['status' => 2]);

               
            }

            else if(isset($_POST['submitApprove'])){
                Mail::send('email.emailToUserAndCatApproval' ,$data, function($message) use ($user_email,$email,$data,$cat_email) {
                    $message->to($user_email);
                    $message->cc($cat_email);
                     $message->subject('Grievance Solved.');
                    $message->from($email,'Grievance Cell VESIT');
                 });


                 $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();

                 // -----------------Notification and Status Updating---------------------

        $to= $fetch[0]->user;
        DB::table('notifications')->insert(
                    [
                    'grievance_id'=>$gid,
                    'send_email' => $this->adminEmail,'rec_email' => $to,
                    'msg' => 'Report Approved', 'subject' =>$subj,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                     ]
                );
    
        $grv = grievance::find($gid);
        DB::table('notifications')->insert(
        [
            'grievance_id'=>$gid,
        'send_email' => $this->adminEmail ,'rec_email' => $grv->user_email,'msg' => 'Issue Solved', 'subject' =>$grv->subject,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        
        ]
    
        );
                
        $grvs=DB::table('grievances')
        ->where('id', $gid)
        ->update(['status' => 1]);
        $reports=DB::table('reports')->where('gr_id',$gid)->orderBy('created_at', 'desc')
        ->limit(1)->update(['status' => 1]);

        // -------------Approve else(Part)-------------------------
        // return redirect('/a');
        // }

        // else {
            //e-cell members
            // $cate = DB::table('grievances')->select('category','subject')->where('id', $gid)->get();
            // // return $cate;
            // $cat= $cate[0]->category;
            // $subject= $cate[0]->subject;

            // $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
            // $to= $fetch[0]->user;
            // DB::table('notifications')->insert(
            //             [
            //                 'grievance_id'=>$gid,
            //             'send_email' => '2017.abhay.tiwari@ves.ac.in','rec_email' => $to,'msg' => 'Report Approved', 'subject' =>$subject,
            //             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            //             'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            //             ]
            //         );

        // }



    }

            
       
         return back();

    }

    //AdminMethods
    public function newall()
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grvs= DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status')->where('status','!=',1)->orderByRaw("FIELD(status, '0','3','2')")->orderBy('created_at','Desc')->orderBy('created_at','Desc')->paginate(4);
        return view('admin.index')->with('grvs',$grvs);
        }
    }
    public function approvedall()
    {
        $id=Auth::id();

        if($id==null)
        return redirect('/logout');
        
        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grvs= DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status')->where('status',1)->orderByRaw("FIELD(status, '0','3','2')")->orderBy('created_at','Desc')->paginate(4);
        return view('admin.approved')->with('grvs',$grvs)->with('category',"All");
        }
    }
    public function pendingall()
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grvs= DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status')->where('status','!=',1)->orderBy('id','Desc')->orderByRaw("FIELD(status, '0','3','2')")->paginate(4);
        
        return view('admin.pending')->with('grvs',$grvs)->with('category',"All");   
        }
    }
    public function approved($id1)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grvs= DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status') ->where('category', $id1)->where('status',1)->orderByRaw("FIELD(status, '0','3','2')")->orderBy('created_at','Desc')->paginate(4);
        if($id1==1)
        {
            $id1='Academics Category';
        }
        else if($id1==0)
        {
            $id1='All';
        }
        else if($id1==2)
        {
            $id1='Cleanliness Category';
        }
        else if($id1==3)
        {
            $id1='Infrastructure Category';
        }
        else if($id1==4)
        {
            $id1='Harrasment Category';
        }
        else if($id1==5)
        {
            $id1='Disciplinary Action Category';
        } 
        
        return view('admin.approved')->with('grvs',$grvs)->with('category',$id1);
        }
    }
    public function pending($id1)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grvs= DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status') ->where('category', $id1)->where('status','!=',1)->orderByRaw("FIELD(status, '0','3','2')")->orderBy('created_at','Desc')->paginate(4);
        if($id1==1)
        {
            $id1='Academics Category';
        }
        else if($id1==0)
        {
            $id1='All';
        }
        else if($id1==2)
        {
            $id1='Cleanliness Category';
        }
        else if($id1==3)
        {
            $id1='Infrastructure Category';
        }
        else if($id1==4)
        {
            $id1='Harrasment Category';
        }
        else if($id1==5)
        {
            $id1='Disciplinary Action Category';
        } 
        return view('admin.pending')->with('grvs',$grvs)->with('category',$id1);
        }
    }
    public function showgrv($id1)
    {
        $id=Auth::id();

        if($id==null)
        return redirect('/logout');
        $user = user::find($id);
        $role=$user->role;
        if($role!=0){
            return redirect('/logout');
        }
        else
        {
        $grv = grievance::find($id1);
        return view('admin.showgrv')->with('grv',$grv);
        }
    }
    public function new($id1)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        
        {
            $grvs= DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status') ->where('category', $id1)->where('status','!=',1)->orderByRaw("FIELD(status, '0','3','2')")->orderBy('created_at','Desc')->paginate(4);
        //     $grvs= DB::statement( 'SELECT category,description,subject,id,created_at,updated_at,status
        //     FROM   grievances
        //     WHERE  id IN (
        //         SELECT   gr_id
        //         FROM     reports
        //         WHERE    status = 0
        //        )
        
        // ')->get();

            return view('admin.index')->with('grvs',$grvs);
        }
    }
    public function asked($id1)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grvs=DB::table('grievances')
        ->where('id', $id1)
        ->update(['status' => 3]);
        // $cate = DB::table('grievances')->select('category','subject')->where('id', $id)->get();
        // $cat= $cate[0]->category;
        // $subject= $cate[0]->subject;
        
        // $fetch = DB::table('categories')->select('user_email')->where('category',$cat)->get();
        // $to= $fetch[0]->user_email;
        // DB::table('notifications')->insert(
        //             ['send_email' => 'admin','rec_email' => $to,'msg' => 'Waiting for a report', 'subject' =>$subject]
        //         );
                
        

        return redirect('/a');
        }
    }
//     public function onapprove($gid)
//     {
//         $id=Auth::id();
//         $user = user::find($id);
//         $role=$user->role;
//         if($role==2)
//         return redirect('/logout');
//         else if($role==0)
//         {
//         $cate = DB::table('grievances')->select('category','subject')->where('id', $gid)->get();
//         // return $cate;
//         $cat= $cate[0]->category;
//         $subject= $cate[0]->subject;
        

//         //CHANGE 2
//         //ADMIN MAIL CHANGE

//         $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
//         $to= $fetch[0]->user;
//         DB::table('notifications')->insert(
//                     [
//                     'grievance_id'=>$gid,
//                     'send_email' => '2017.abhay.tiwari@ves.ac.in','rec_email' => $to,
//                     'msg' => 'Report Approved', 'subject' =>$subject,
//                     'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
//                     'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
//                      ]
//                 );
    
//         $grv = grievance::find($gid);
//         DB::table('notifications')->insert(
//         [
//             'grievance_id'=>$gid,
//         'send_email' => '2017.abhay.tiwari@ves.ac.in' ,'rec_email' => $grv->user_email,'msg' => 'Issue Solved', 'subject' =>$grv->subject,
//         'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
//          'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        
//         ]
    
//         );
                
//         $grvs=DB::table('grievances')
//         ->where('id', $gid)
//         ->update(['status' => 1]);
//         $reports=DB::table('reports')->where('gr_id',$gid)->orderBy('created_at', 'desc')
//         ->limit(1)->update(['status' => 1]);

//         // ---------Approvel email to user and cat------------------------------------------------------------------
//         $adminReply=$_POST['description'];
//         $grev=Grievance::find($gid);
//         $subj=$grev->subject;  
//         $cat=$grev->category;
//         $user_email=$grev->user_email;
       
//         $cat_email=categories::find($cat)->user;
//     //   dd("adminRejectMail");
        
//        $email="hjminves@gmail.com";


//     $data=array(
//         'email'=>$email,
//         'grev'=>$grev,
//         'adminReply'=>$adminReply,
        
//     );
//     dd($adminReply);

// Mail::send('email.emailToUserAndCatApproval' ,$data, function($message) use ($user_email,$email,$data,$cat_email) {
//     $message->to($user_email);
//     $message->cc($cat_email);
//      $message->subject('Grievance Solved.');
//     $message->from($email,'Grievance Cell VESIT');
//  });
        
        
        
        
        
        
        
        // ----------------------------------------------------------------------------------------------------------------------
        
        // return redirect('/a');
        // }

        // else {
        //     //e-cell members
        //     $cate = DB::table('grievances')->select('category','subject')->where('id', $gid)->get();
        //     // return $cate;
        //     $cat= $cate[0]->category;
        //     $subject= $cate[0]->subject;

        //     $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
        //     $to= $fetch[0]->user;
        //     DB::table('notifications')->insert(
        //                 [
        //                     'grievance_id'=>$gid,
        //                 'send_email' => '2017.abhay.tiwari@ves.ac.in','rec_email' => $to,'msg' => 'Report Approved', 'subject' =>$subject,
        //                 'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        //                 'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        //                 ]
        //             );

        // }
    // }
    public function onreject($gid)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        // if($role!=0)
        // return redirect('/logout');
        // else
        if($role==0)
        {
            $cate = DB::table('grievances')->select('category','subject')->where('id', $gid)->get();
            // return $cate;
            $cat= $cate[0]->category;
            $subject= $cate[0]->subject;
            
            $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
            $to= $fetch[0]->user;
           


            DB::table('notifications')->insert(
                        [
                            'grievance_id'=>$gid,
                        'send_email' => $this->adminEmail,'rec_email' => $to,'msg' => 'Report Rejected', 'subject' =>$subject,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
                    );
        
        $reports=DB::table('reports')->where('gr_id',$gid)->where('status',0)->orderBy('created_at', 'desc')
        ->limit(1)->update(['status' => 2]);
        return redirect('/a/pending');
        }


        else if($role==1){


            $cate = DB::table('grievances')->select('category','subject')->where('id', $gid)->get();
            $cat= $cate[0]->category;
            $subject= $cate[0]->subject;
            dd("onreject");
            $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
            
         $grv = grievance::find($gid);
             $message="Issue rejected. Apply Again";   
       //dump($grv->user_email);
        DB::table('notifications')->insert(
        [
            'grievance_id'=>$gid,
        'send_email' => '2017.hrithik.malvani@ves.ac.in' ,'rec_email' => $grv->user_email,'msg' => $message, 'subject' =>$grv->subject,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
    
        );

            $reports=DB::table('reports')->where('gr_id',$gid)->where('status',0)->orderBy('created_at', 'desc')
        ->limit(1)->update(['status' => 2]);    
    // dump($reports);
            return redirect('/c/notifications');

        }
    }
    public function showreportfinal($grvid)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grv = grievance::find($grvid);
        $reports=DB::table('reports')->select('r_id','gr_id','description','created_at')->where('gr_id',$grvid)->orderBy('created_at', 'desc')
        ->limit(1)->get();
        return view('admin.showreportfinal')->with('reports',$reports)->with('grv',$grv);
        }
    }
    public function showreportpending($grvid)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grv = grievance::find($grvid);
        $reports=DB::table('reports')->select('r_id','gr_id','description','created_at','status')->where('gr_id',$grvid)->orderBy('created_at', 'desc')->paginate(4);
        $reports_l=DB::table('reports')->select('r_id','gr_id','description','created_at')->where('gr_id',$grvid)->where('status',0)->orderBy('created_at', 'desc')->limit(1)->get();
        return view('admin.showreportpending')->with('reports',$reports)->with('reports_l',$reports_l)->with('grv',$grv);
        }
    }
    
    //UserMethods
    public function showreportfinal_u($grvid)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=2)
        return redirect('/logout');
        else
        {
        $grv = grievance::find($grvid);
        $reports=DB::table('reports')->select('r_id','gr_id','description','created_at')->where('gr_id',$grvid)->where('status',1)->orderBy('created_at', 'desc')
        ->limit(1)->get();
        return view('user.showreportfinal')->with('reports',$reports)->with('grv',$grv);
        }
    }
    public function show($id1)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=2)
        return redirect('/logout');
        else
        
        {
            $grv = grievance::find($id1);
            return view('user.showgrv')->with('grv',$grv);
        }
    }
    public function form(){
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
         
        //  if($role==2)
        // // 
        // // else
        if(auth()->user()->role==2){
        return view ('user.new_grv');}  
        else return redirect('/logout');
        // }
    }
    
    public function history(Request $request)
    {


        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=2)
        return redirect('/logout');
        else
        {
        $id=$user->email;
        $grvs=DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status') ->where('user_email', $id)->orderByRaw("FIELD(status, '0','3','2','1')")->orderBy('created_at','Desc')->paginate(4);
        return view('user.history')->with('grvs',$grvs);
        }
    }
    public function store(Request $request)
    {
           
        
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=2)
        return redirect('/logout');
        else

        
        {

           
            $request->validate( 
            [
                
                'description'=> 'required|max:500',
                'category'=> 'required',
                'subject'=> 'required| max:100'
                
            ]);
        //    ----------------------Spell Check----------------------------------------
        
//         $source = new StringSource('Tiger, tigr, burning bright');
//         putenv('LANG=en_US.UTF-8');
//         $_SERVER['LANG'] = 'en_US.UTF-8';
// $speller = new Hunspell();
// $issues = $speller->checkText($source, ['en_GB', 'en']);

// echo $issues[0]->word; // -> "tigr"
// echo $issues[0]->line; // -> 1
// echo $issues[0]->offset; // -> 7
// dd($issues);
// echo implode(',', $issues[0]->suggestions); 
        // require_once('C:\xampp\htdocs\gms1\public\pspell.php');
        
        // $content = "";
        // $options = array(
        //     "lang"				=> 'en',
        //     "maxSuggestions"		=> 10,
        //     "customDict"			=> 0,
        //     "charset"			=> 'utf-8'
        // );
        // // dd(1234);
        // $factory = new \GenericSpellChecker("hello",$options);

        // $spell = $factory->create(trim("Ths is a tst"));
// dd($spell);
        // header('Content-Type: text/xml; charset=UTF-8');
        // return $spell->toXML();
        // --------------------------------------------------------------------------------
        //     //move to database
            $grievance = new grievance;
            $grievance->category = $request->input('category');
            //$grievance->category = $request->input('user_email');
            $grievance->subject = $request->input('subject');
            $grievance->user_email = $user->email;
            $grievance->description = $request->input('description');
            $grievance->save();
          // dd($grievance->id);
            $user_email= $user->email;
            $subject=$request->input('subject');

            $cat=$request->input('category');
            $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
          
           if(count($fetch)>0)
            $to= $fetch[0]->user;
           else return back()->withErrors("No E-cell member appointed for this Category of Complaint."); 
           

            DB::table('notifications')->insert(
            [
            'grievance_id'=>$grievance->id,                       
            'send_email' => $user_email ,'rec_email' => $this->adminEmail,'msg' => 'New Grievance', 'subject' =>$subject,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString() ]
        
            );
            
          

          
            DB::table('notifications')->insert(
                        [
                        'grievance_id'=>$grievance->id,
                        'send_email' => $user_email,'rec_email' => $to,'msg' => 'New Grievance', 'subject' =>$subject,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
                    );
            
            // $message="hii";
            // Mail::to($user_email)->send($message);

//SEND EMAIL TO ADMIN FOR NEW GRIEVANCE SUBMITTED

            $email="hjminves@gmail.com";
            $admin_email=$this->adminEmail;
            $cat_temp=$grievance->category;
            
            $cat=categories::find($cat_temp);
            $cat_email=$cat->user;
            // dd($cat_email);
            $data=array(
                'email'=>$email,
                'grievance'=>$grievance,
                // 'adminReply'=>$adminReply,
                
            );
            // $emailArray=array('','');
            // dd($emailArray);

        Mail::send('email.mailToCellMember' ,$data, function($message) use ($email,$cat_email,$data,$admin_email) {
            $message->to($cat_email);
            $message->cc($admin_email);
             $message->subject('New Grievance');
            $message->from($email,'Grievance Cell VESIT');
         });


         

                return redirect('/u')->with('success','Grievance submitted Successfully');
        }
    }


    //CellMethods
    public function storerep(Request $request)

    {
        
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);

        $role=$user->role;
        $email="hjminves@gmail.com";
        if($role!=1)
        return redirect('/logout');
        else
        
        {
            $this->validate(
                request(),[
                    'desc'=>'required|max:500',
                    
                ]
                );


            $report = new report;
            $report->gr_id = $request->input('gid');
           
            $gid=$request->input('gid');
            $report->description = $request->input('desc');
            $report->status= 0;


            $report->save();
            
            
            $cate = DB::table('grievances')->select('category','subject')->where('id', $gid)->get();
            // return $cate;
            if(count($cate)>0)
                $cat= $cate[0]->category;
            else return back()->withErrors("Some Error has occurred."); 
    
            $subject= $cate[0]->subject;
            
            $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
           if(count($fetch)>0)
            $to= $fetch[0]->user;
            else return back()->withErrors("No E-cell member appointed for this Category of Complaint."); 
 
            $from=$to;
           
            $grv = grievance::find($gid);
           
          

                if(isset($_POST['toAdmin'])){

                    $data=array(
                        'email'=>$email,
                        'grv'=>$grv,
                        'to'=>$from,
                        'description'=>$report->description,
                        'category'=>$grv->category,
                        // 'adminReply'=>$adminReply,
                        
                    );
                    
                    DB::table('notifications')->insert(
                        [
                        'grievance_id'=>$gid,
                        'send_email' => $to ,'rec_email' =>$this->adminEmail ,'msg' => 'New Report from E-cell ', 'subject' =>$grv->subject,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
   
                         );

                        //  ---------Mail to Admin fro Report------------------

                       
                       
                        Mail::send('email.emailToAdminForReport' ,$data, function($message) use ($email,$data) {
                            $message->to($this->adminEmail);
                            // $message->cc($cat_email);
                             $message->subject('New Report from Cell-Member');
                            $message->from($email,'Grievance Cell VESIT');
                         });

                        //  ---------------------------------------------------

                }
                    
                else if(isset($_POST['toUser'])){
                    $user_data=array(
                        'email'=>$email,
                        'grv'=>$grv,
                        'to'=>$grv->user_email,
                        'description'=>$report->description,
                        
                        // 'adminReply'=>$adminReply,
                        
                    );
                    $usermail=$grv->user_email;
                     
                     DB::table('notifications')->insert(
                     [
                          'grievance_id'=>$gid,
                    'send_email' => $to ,'rec_email' =>$grv->user_email ,'msg' => 'Grievance Rejected', 'subject' =>$grv->subject,
                     'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]

                      );

                    //   -------------Mail to User for Rejection by CAt--------------------
                    Mail::send('email.emailToUserForRejectByCat' ,$user_data, function($message) use ($email,$user_data,$usermail) {
                        $message->to($usermail);
                        // $message->cc($cat_email);
                         $message->subject('Your Grievance is not Valid');
                        $message->from($email,'Grievance Cell VESIT');
                     });

                    //  ------------------------------------------------------------------------
                }
                
               
//        // dd($grv->id);
//         $email=$user->email;
//         $origi_grev_id=$grv->id;


//         // dump($email);
//         // dump($grv->user_email);
//         $notif=notification::where('rec_email',$email)->where('status',0)->where('subject',$grv->subject)->where('send_email',$grv->user_email)->get();
//  //dd($notif);
//                 //CHANGE 1
//                 $var=DB::table('notifications')
//                     ->where('id', $notif[0]->id)
//                     ->update(['status' => 1]);

//                   //  dd($id);
        

            $this->validate($request,
            [
            'desc'=> 'required|max:500'

            ]);
            // //move to database
            DB::table('grievances')
            ->where('id', $gid)
            ->update(['status' => 2]); //2=Pending Result 

            return redirect('/c/reports');

        }
     

    }


    











    public function showreport($grvid)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=1)
        return redirect('/logout');
        else
        
        {
            $grv = grievance::find($grvid);
            $reports=DB::table('reports')->select('r_id','gr_id','description','created_at','status')->where('gr_id',$grvid)->orderBy('created_at','Desc')->paginate(4);
            return view('cm.showreport')->with('reports',$reports)->with('grv',$grv);
        }
    }
    
    public function writereport($id1)
    {
        
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $role=$user->role;
        if($role!=1)
        return redirect('/logout');
        else
        
        {    
            $grv= grievance::find($id1);
            //dump($grev);
            return view('cm.write')->with('grv',$grv);
        }
    }


    public function showGrievanceDetail($id){
       // $grvs= DB::table('grievances')->where("id",$id);
       $grvs=Grievance::find($id);
        // dd($grvs->subject);
        return view("cm.showGrievanceDetail",compact('id','grvs'));
    }

    public function cat(Request $request)
    {
        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

        $user = user::find($id);
        $name = $user->name;
        $email=$user->email;
        $role=$user->role;
        
        if($role!=1)
        return redirect('/logout');
        else
        
        {
            // $cate = categories::find($email);
            // $cat=$cate->category;
            //solved by third year guy
            $cate= DB::table('categories')->select('category')->where('user',$email)->get();
            // $cat=categories::find($id);
        
     
            $cat=$cate[0]->category;
            
            $grvs= DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status') ->where('category',$cat)->where('status',0)->orderBy('created_at','Desc')->paginate(4);
            return view('cm.index')->with('grvs',$grvs);
        }
    }
   
    
    
    public function history_c(Request $request)
    {

        $id=Auth::id();
        if($id==null)
        return redirect('/logout');

       
        $user = user::find($id);

        $email=$user->email;
       
        $role=$user->role;
        if($role!=1)
        return redirect('/logout');
        else
        {
            //aim to get the category number
            $cat= DB::table('categories')->select('category')->where('user',$email)->get();
          

           
            $cat= $cat[0]->category;
           
            // $cat=categories::find($id);
            
        $grvs=DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status')->where('category',$cat)->orderByRaw("FIELD(status, '0','3','2','1')")->orderBy('created_at','Desc')->get();
        // ->where('status', '!=',0)
        // ->where('category',$cat)->orderByRaw("FIELD(status, '0','3','2','1')")->orderBy('created_at','Desc')->get()
        return view('cm.history')->with('grvs',$grvs);
        }
    }
    
    
}
