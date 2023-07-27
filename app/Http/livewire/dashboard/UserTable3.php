<?php
 
namespace App\Http\Livewire\dashboard;
 
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
 
class UserTable3 extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';
 
    public $name, $email, $role, $student_id, $status;
    public $search = '';
 
    protected function rules()
    {
        return [
            'name' => 'required|string|min:6',
            'email' => ['required','email'],
            'role' => 'required',
        ];
    }
 
    public function updated($fields)
    {
        $this->validateOnly($fields);
    }
 
    public function saveStudent()
    {
        $validatedData = $this->validate();
        $validatedData['status'] = 1; // Set the default status value here
 
        User::create($validatedData);
        session()->flash('message','Student Added Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }
     
    public function editStudent(int $student_id)
    {
        $student = User::find($student_id);
        if($student){
 
            $this->student_id = $student->id;
            $this->name = $student->name;
            $this->email = $student->email;
            $this->role = $student->role;
        }else{
            return redirect()->to('/rest');
        }
    }
 
    public function updateStudent()
    {
        $validatedData = $this->validate();
 
        User::where('id',$this->student_id)->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role']
        ]);
        session()->flash('message','Student Updated Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('close-modal');
    }

    public function updateStatus(int $student_id)
    {
        $userState = User::find($student_id);

        // Toggle the status (0 to 1 and 1 to 0)
        $userState->status = $userState->status == 0 ? 1 : 0;
    
        $userState->save();
        session()->flash('message', 'User Status Updated Successfully');
    }
     
    public function deleteStudent(int $student_id)
    {
        $this->student_id = $student_id;
    }
 
    public function destroyStudent()
    {
        User::find($this->student_id)->delete();
        session()->flash('message','Student Deleted Successfully');
        $this->dispatchBrowserEvent('close-modal');
    }
 
    public function closeModal()
    {
        $this->resetInput();
    }
 
    public function resetInput()
    {
        $this->name = '';
        $this->email = '';
        $this->role = '';
    }
 
    public function render()
    {
        $colspan = 6;
        $cols = ['#','Name','email','status','role','actions'];
        $students = User::where('name', 'like', '%'.$this->search.'%')
        ->orWhere('email', 'like', '%' . $this->search . '%')
        ->orWhere('role', 'like', '%' . $this->search . '%')
        ->orderBy('id','DESC')
        ->paginate(2);
        
        //$students = Student::select('id','name','email','course')->get();
        return view('dashboard.livewire.user-table2', ['students' => $students, 'cols' => $cols, 'colspan' => $colspan]);
    }
}