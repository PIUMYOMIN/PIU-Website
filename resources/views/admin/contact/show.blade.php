<x-admin_layout>
    <div class="sb2-2-2">
        <ul>
            <li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Dashboard</a>
            </li>
            <li class="page-back"><a href="/admin"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp admin-form">
                    <div class="inn-title">
                        <h4>Contact Information</h4>
                        <p>You're strongly recommended to use the desktop computer to view the student details.</p>
                    </div>
                    <div class="udb-sec udb-prof">
                        <div class="sdb-tabl-com sdb-pro-table">
                            <table class="responsive-table bordered">
                                <tbody>
                                    <tr>
                                        <td>Contact Name</td>
                                        <td>:</td>
                                        <td>{{ $contact->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact Email</td>
                                        <td>:</td>
                                        <td>{{ $contact->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact Phone</td>
                                        <td>:</td>
                                        <td>{{ $contact->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Message</td>
                                        <td>:</td>
                                        <td>{{ $contact->message }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin_layout>
