@extends('layouts.alumni')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Graduate Tracer Study Questionnaire</h1>
    <form action="{{ route('tracer-study.submit') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Part A: General Information</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">1. Name: (Optional)</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="year_graduated" class="form-label">2. Year of Graduation:</label>
                    <input type="number" class="form-control" id="year_graduated" name="year_graduated" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">3. Age:</label>
                    <input type="number" class="form-control" id="age" name="age">
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">4. Gender:</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="marital_status" class="form-label">5. Marital Status:</label>
                    <input type="text" class="form-control" id="marital_status" name="marital_status">
                </div>
                <div class="mb-3">
                    <label for="current_location" class="form-label">6. Current Location:</label>
                    <input type="text" class="form-control" id="current_location" name="current_location">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">7. Contact Information: Email Address</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h2 class="mb-0">Part B: Educational Background</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="degree_program" class="form-label">1. Degree Program:</label>
                    <input type="text" class="form-control" id="degree_program" name="degree_program" required>
                </div>
                <div class="mb-3">
                    <label for="major" class="form-label">2. Major: (If applicable)</label>
                    <input type="text" class="form-control" id="major" name="major">
                </div>
                <div class="mb-3">
                    <label for="minor" class="form-label">3. Minor: (If applicable)</label>
                    <input type="text" class="form-control" id="minor" name="minor">
                </div>
                <div class="mb-3">
                    <label for="gpa" class="form-label">4. Overall GPA:</label>
                    <input type="number" step="0.01" min="0" max="4" class="form-control" id="gpa" name="gpa">
                </div>
                <div class="mb-3">
                    <label class="form-label">5. How satisfied were you with the following aspects of your education?</label>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Aspect</th>
                                <th>Very Satisfied</th>
                                <th>Satisfied</th>
                                <th>Neutral</th>
                                <th>Dissatisfied</th>
                                <th>Very Dissatisfied</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['Quality of Instruction', 'Curriculum Relevance', 'Availability of Resources', 'Faculty Support', 'Career Advising', 'Extracurricular Activities'] as $aspect)
                                <tr>
                                    <td>{{ $aspect }}</td>
                                    @foreach(['Very Satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very Dissatisfied'] as $rating)
                                        <td>
                                            <input type="radio" name="satisfaction_{{ Str::slug($aspect) }}" value="{{ $rating }}" required>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h2 class="mb-0">Part C: Employment Status</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="employment_status" class="form-label">1. Are you currently employed?</label>
                    <select class="form-select" id="employment_status" name="employment_status" required>
                        <option value="">Select</option>
                        <option value="Employed">Yes</option>
                        <option value="Unemployed">No</option>
                    </select>
                </div>

                <div id="employed-section" style="display: none;">
                    <div class="mb-3">
                        <label for="job_title" class="form-label">Job Title:</label>
                        <input type="text" class="form-control" id="job_title" name="job_title">
                    </div>
                    <div class="mb-3">
                        <label for="company" class="form-label">Company/Organization:</label>
                        <input type="text" class="form-control" id="company" name="company">
                    </div>
                    <div class="mb-3">
                        <label for="industry" class="form-label">Industry:</label>
                        <input type="text" class="form-control" id="industry" name="industry">
                    </div>
                    <div class="mb-3">
                        <label for="nature_of_work" class="form-label">Nature of Work:</label>
                        <input type="text" class="form-control" id="nature_of_work" name="nature_of_work" placeholder="e.g., Academic, Supervisory, Technical">
                    </div>
                    <div class="mb-3">
                        <label for="employment_sector" class="form-label">Employment Sector:</label>
                        <input type="text" class="form-control" id="employment_sector" name="employment_sector" placeholder="e.g., Public, Private, Self-Employed">
                    </div>
                    <div class="mb-3">
                        <label for="tenure_status" class="form-label">Tenure Status:</label>
                        <input type="text" class="form-control" id="tenure_status" name="tenure_status" placeholder="e.g., Regular/Permanent, Contractual, Temporary">
                    </div>
                    <div class="mb-3">
                        <label for="monthly_salary" class="form-label">Monthly Salary: (Optional)</label>
                        <input type="number" class="form-control" id="monthly_salary" name="monthly_salary">
                    </div>
                    <div class="mb-3">
                        <label for="time_to_first_job" class="form-label">How long did it take you to find your first job after graduation?</label>
                        <input type="text" class="form-control" id="time_to_first_job" name="time_to_first_job">
                    </div>
                    <div class="mb-3">
                        <label for="job_finding_method" class="form-label">How did you find your first job?</label>
                        <input type="text" class="form-control" id="job_finding_method" name="job_finding_method" placeholder="e.g., Recommendation, Online Job Portal, Career Fair">
                    </div>
                    <div class="mb-3">
                        <label for="job_related_to_degree" class="form-label">Is your current job related to your degree program?</label>
                        <select class="form-select" id="job_related_to_degree" name="job_related_to_degree">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="job_unrelated_reason" class="form-label">If no, please briefly explain why:</label>
                        <textarea class="form-control" id="job_unrelated_reason" name="job_unrelated_reason" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="useful_skills" class="form-label">What skills learned in college are most useful in your current job?</label>
                        <textarea class="form-control" id="useful_skills" name="useful_skills" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="desired_skills" class="form-label">What skills or knowledge do you wish you had acquired in college that would be beneficial in your current role?</label>
                        <textarea class="form-control" id="desired_skills" name="desired_skills" rows="3"></textarea>
                    </div>
                </div>

                <div id="unemployed-section" style="display: none;">
                    <div class="mb-3">
                        <label for="seeking_employment" class="form-label">Are you currently seeking employment?</label>
                        <select class="form-select" id="seeking_employment" name="seeking_employment">
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="job_types_sought" class="form-label">If yes, what types of jobs are you looking for?</label>
                        <textarea class="form-control" id="job_types_sought" name="job_types_sought" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="employment_challenges" class="form-label">What challenges have you faced in finding employment?</label>
                        <textarea class="form-control" id="employment_challenges" name="employment_challenges" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="reason_not_seeking" class="form-label">If you are not seeking employment, please indicate the reason:</label>
                        <input type="text" class="form-control" id="reason_not_seeking" name="reason_not_seeking" placeholder="e.g., Further Studies, Family Concerns">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-warning">
                <h2 class="mb-0">Part D: Feedback and Suggestions</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="program_strengths" class="form-label">1. What are the strengths of your undergraduate program?</label>
                    <textarea class="form-control" id="program_strengths" name="program_strengths" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="program_improvements" class="form-label">2. What areas of your undergraduate program could be improved?</label>
                    <textarea class="form-control" id="program_improvements" name="program_improvements" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="program_recommendations" class="form-label">3. What specific recommendations do you have for enhancing the quality and relevance of your degree program?</label>
                    <textarea class="form-control" id="program_recommendations" name="program_recommendations" rows="3" placeholder="e.g., Curriculum Updates, Enhanced Faculty Training, Improved Facilities"></textarea>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const employmentStatus = document.getElementById('employment_status');
        const employedSection = document.getElementById('employed-section');
        const unemployedSection = document.getElementById('unemployed-section');

        employmentStatus.addEventListener('change', function() {
            if (this.value === 'Yes') {
                employedSection.style.display = 'block';
                unemployedSection.style.display = 'none';
            } else if (this.value === 'No') {
                employedSection.style.display = 'none';
                unemployedSection.style.display = 'block';
            } else {
                employedSection.style.display = 'none';
                unemployedSection.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection

