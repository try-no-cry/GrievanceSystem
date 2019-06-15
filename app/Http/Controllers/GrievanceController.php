<?php


namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\grievance;
use App\report;
use App\user;
use Mail\news;
use App\categories;
use App;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\notification;
class GrievanceController extends Controller
{
    public function showSearchResultAdmin(){

        $q = Input::get ( 'q' );
        $grvs = Grievance::where('subject','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%')->orWhere('user_email','LIKE','%'.$q.'%')->get();
        
          return view('admin.searchResults',compact('grvs'))->withQuery ( $q );
        
    }
   
    public function changeP()
    {
        
        $id=Auth::id();
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
        $id=Auth::id();
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
            "description"=>'required'
        ]);

         $adminReply=$_POST['description'];

                $grev=Grievance::find($gid);
                $subj=$grev->subject;  
                $cat=$grev->category;
               
               // $cat_email=categories::find($cat)->user;
              
                
               // $email=Session::get('email'); 
               $email="hjminves@gmail.com";
                 $cat_email="jai.soneji@gmail.com";


            $data=array(
                'email'=>$email,
                'grev'=>$grev,
                'adminReply'=>$adminReply,
                
            );

        Mail::send('email.adminReportRejectMail' ,$data, function($message) use ($email,$data,$cat_email) {
            $message->to($cat_email);
             $message->subject('Report for the grievance rejected.');
            $message->from($email,'Grievance Cell VESIT');
         });

         $reports=DB::table('reports')->where('gr_id',$gid)->where('status',0)->orderBy('created_at', 'desc')
         ->limit(1)->update(['status' => 2]);
         return back();

    }

    //AdminMethods
    public function newall()
    {
        $id=Auth::id();
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
        $user = user::find($id);
        $role=$user->role;
        if($role!=0)
        return redirect('/logout');
        else
        {
        $grvs= DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status')->where('status','!=',1)->orderByRaw("FIELD(status, '0','3','2')")->orderBy('id','Desc')->paginate(4);
        
        return view('admin.pending')->with('grvs',$grvs)->with('category',"All");   
        }
    }
    public function approved($id1)
    {
        $id=Auth::id();
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
    public function onapprove($gid)
    {
        $id=Auth::id();
        $user = user::find($id);
        $role=$user->role;
        if($role==2)
        return redirect('/logout');
        else if($role==0)
        {
        $cate = DB::table('grievances')->select('category','subject')->where('id', $gid)->get();
        // return $cate;
        $cat= $cate[0]->category;
        $subject= $cate[0]->subject;
        

        //CHANGE 2

        $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
        $to= $fetch[0]->user;
        DB::table('notifications')->insert(
                    ['send_email' => 'admin@gmail.com','rec_email' => $to,'msg' => 'Report Approved', 'subject' =>$subject,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                    ]
                );
    
        $grv = grievance::find($gid);
        DB::table('notifications')->insert(
        ['send_email' => 'admin@gmail.com' ,'rec_email' => $grv->user_email,'msg' => 'Issue Solved', 'subject' =>$grv->subject,
        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
         'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
        
        ]
    
        );
                
        $grvs=DB::table('grievances')
        ->where('id', $gid)
        ->update(['status' => 1]);
        $reports=DB::table('reports')->where('gr_id',$gid)->orderBy('created_at', 'desc')
        ->limit(1)->update(['status' => 1]);
        
        return redirect('/a');
        }

        else {
            //e-cell members
            $cate = DB::table('grievances')->select('category','subject')->where('id', $gid)->get();
            // return $cate;
            $cat= $cate[0]->category;
            $subject= $cate[0]->subject;

            $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
            $to= $fetch[0]->user;
            DB::table('notifications')->insert(
                        ['send_email' => 'admin@gmail.com','rec_email' => $to,'msg' => 'Report Approved', 'subject' =>$subject,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
                        ]
                    );

        }
    }
    public function onreject($gid)
    {
        $id=Auth::id();
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
            dump($to);


            DB::table('notifications')->insert(
                        ['send_email' => 'admin@gmail.com','rec_email' => $to,'msg' => 'Report Rejected', 'subject' =>$subject,
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
            $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
            
         $grv = grievance::find($gid);
             $message="Issue rejected. Apply Again";   
       //dump($grv->user_email);
        DB::table('notifications')->insert(
        ['send_email' => 'cat'.$cat.'@gmail.com' ,'rec_email' => $grv->user_email,'msg' => $message, 'subject' =>$grv->subject,
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
        $user = user::find($id);
        $role=$user->role;

        if($role!=2)
        return redirect('/logout');
        else
        {
            $this->validate($request,
            [
                'description'=> 'required',
                'category'=> 'required',
                'subject'=> 'required'
                
            ]);
            //move to database
            $grievance = new grievance;
            $grievance->category = $request->input('category');
            //$grievance->category = $request->input('user_email');
            $grievance->subject = $request->input('subject');
            $grievance->user_email = $user->email;
            $grievance->description = $request->input('description');
            $grievance->save();
            $user_email= $user->email;
            $subject=$request->input('subject');
            DB::table('notifications')->insert(
            ['send_email' => $user_email ,'rec_email' => 'admin@gmail.com','msg' => 'New Grievance', 'subject' =>$subject,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
        
            );
            $cat=$request->input('category');
            $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
            $to= $fetch[0]->user;
            DB::table('notifications')->insert(
                        ['send_email' => $user_email,'rec_email' => $to,'msg' => 'New Grievance', 'subject' =>$subject,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
                    );
            
            // $message="hii";
            // Mail::to($user_email)->send($message);

                return redirect('/u')->with('success','Grievance submitted Successfully');
        }
    }


    //CellMethods
    public function storerep(Request $request)

    {
        
        $id=Auth::id();
        $user = user::find($id);
        $role=$user->role;
        if($role!=1)
        return redirect('/logout');
        else
        
        {
            $this->validate(
                request(),[
                    'desc'=>'required'
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
            $cat= $cate[0]->category;
            $subject= $cate[0]->subject;

            $fetch = DB::table('categories')->select('user')->where('category',$cat)->get();
            $to= $fetch[0]->user;
           
            $grv = grievance::find($gid);
          

                if(isset($_POST['toAdmin'])){
                    
                    DB::table('notifications')->insert(
                        ['send_email' => $to ,'rec_email' =>"admin@gmail.com" ,'msg' => 'New Report to check11111111111111', 'subject' =>$grv->subject,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]
   
                         );
                }
                    
                else if(isset($_POST['toUser'])){
                     
                     DB::table('notifications')->insert(
                     ['send_email' => $to ,'rec_email' =>$grv->user_email ,'msg' => 'New Report to check11111111111111', 'subject' =>$grv->subject,
                     'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => \Carbon\Carbon::now()->toDateTimeString()]

                      );
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
            'desc'=> 'required'

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
            
        $grvs=DB::table('grievances')->select('category','description','subject','id','created_at','updated_at','status') ->where('status', '!=',0)->where('category',$cat)->orderByRaw("FIELD(status, '0','3','2','1')")->orderBy('created_at','Desc')->paginate(4);
       
           
        return view('cm.history')->with('grvs',$grvs);
        }
    }
    
    
}
