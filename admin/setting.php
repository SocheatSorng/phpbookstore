<?php
include 'includes/header.php';
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Start transaction
        $conn->beginTransaction();
        
        // Store settings based on form section
        if (isset($_POST['general_settings'])) {
            $stmt = $conn->prepare("UPDATE tbSettings SET 
                meta_title = ?,
                meta_keywords = ?,
                theme = ?,
                layout = ?,
                description = ?
                WHERE id = 1");
                
            $stmt->execute([
                $_POST['meta_title'],
                $_POST['meta_keywords'],
                $_POST['theme'],
                $_POST['layout'],
                $_POST['description']
            ]);
        }
        
        if (isset($_POST['store_settings'])) {
            $stmt = $conn->prepare("UPDATE tbSettings SET 
                store_name = ?,
                owner_name = ?,
                owner_phone = ?,
                owner_email = ?,
                store_address = ?,
                zipcode = ?,
                city = ?,
                country = ?
                WHERE id = 1");
                
            $stmt->execute([
                $_POST['store_name'],
                $_POST['owner_name'],
                $_POST['owner_phone'],
                $_POST['owner_email'],
                $_POST['address'],
                $_POST['zipcode'],
                $_POST['city'],
                $_POST['country']
            ]);
        }

        // Commit transaction
        $conn->commit();
        
        // Set success message
        $_SESSION['success_msg'] = "Settings updated successfully!";
        
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollBack();
        $_SESSION['error_msg'] = "Error updating settings: " . $e->getMessage();
    }
    
    // Redirect to refresh page
    header("Location: settings.php");
    exit();
}

// Fetch current settings
try {
    $stmt = $conn->query("SELECT * FROM tbSettings WHERE id = 1");
    $settings = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching settings: " . $e->getMessage());
}
?>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">
     <?php include 'includes/navbar.php'; ?>
     <?php include 'includes/sidebar.php'; ?>

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->
          <div class="page-content">

               <!-- Start Container Fluid -->
               <div class="container-xxl">

                    <!-- Display success/error messages -->
                    <?php if (isset($_SESSION['success_msg'])): ?>
                         <div class="alert alert-success alert-dismissible fade show" role="alert">
                              <?= $_SESSION['success_msg'] ?>
                              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                         </div>
                         <?php unset($_SESSION['success_msg']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error_msg'])): ?>
                         <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <?= $_SESSION['error_msg'] ?>
                              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                         </div>
                         <?php unset($_SESSION['error_msg']); ?>
                    <?php endif; ?>

                    <!-- Main Settings Form -->
                    <form method="POST" id="settingsForm">
                         <div class="row">
                              <div class="col-lg-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h4 class="card-title d-flex align-items-center gap-1"><iconify-icon icon="solar:settings-bold-duotone" class="text-primary fs-20"></iconify-icon>General Settings</h4>
                                        </div>
                                        <div class="card-body">
                                             <div class="row">
                                                  <div class="col-lg-6">
                                                       <input type="hidden" name="general_settings" value="1">
                                                       <div class="mb-3">
                                                            <label for="meta-name" class="form-label">Meta Title</label>
                                                            <input type="text" id="meta-name" name="meta_title" class="form-control" placeholder="Title" value="<?= htmlspecialchars($settings['meta_title'] ?? '') ?>">
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="meta-tag" class="form-label">Meta Tag Keyword</label>
                                                            <input type="text" id="meta-tag" name="meta_keywords" class="form-control" placeholder="Enter word" value="<?= htmlspecialchars($settings['meta_keywords'] ?? '') ?>">
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="themes" class="form-label">Store Themes</label>
                                                            <select class="form-control" id="themes" name="theme" data-choices data-choices-groups data-placeholder="Select Themes">
                                                                 <option value="">Default</option>
                                                                 <option value="Dark" <?= $settings['theme'] == 'Dark' ? 'selected' : '' ?>>Dark</option>
                                                                 <option value="Minimalist" <?= $settings['theme'] == 'Minimalist' ? 'selected' : '' ?>>Minimalist</option>
                                                                 <option value="High Contrast" <?= $settings['theme'] == 'High Contrast' ? 'selected' : '' ?>>High Contrast</option>
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="layout" class="form-label">Layout</label>
                                                            <select class="form-control" id="layout" name="layout" data-choices data-choices-groups data-placeholder="Select Layout">
                                                                 <option value="">Default</option>
                                                                 <option value="Electronics" <?= $settings['layout'] == 'Electronics' ? 'selected' : '' ?>>Electronics</option>
                                                                 <option value="Fashion" <?= $settings['layout'] == 'Fashion' ? 'selected' : '' ?>>Fashion</option>
                                                                 <option value="Dining" <?= $settings['layout'] == 'Dining' ? 'selected' : '' ?>>Dining</option>
                                                                 <option value="Interior" <?= $settings['layout'] == 'Interior' ? 'selected' : '' ?>>Interior</option>
                                                                 <option value="Home" <?= $settings['layout'] == 'Home' ? 'selected' : '' ?>>Home</option>
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-12">
                                                       <div class="">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea class="form-control bg-light-subtle" id="description" name="description" rows="4" placeholder="Type description"><?= htmlspecialchars($settings['description'] ?? '') ?></textarea>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div class="col-lg-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h4 class="card-title d-flex align-items-center gap-1"><iconify-icon icon="solar:shop-2-bold-duotone" class="text-primary fs-20"></iconify-icon>Store Settings</h4>
                                        </div>
                                        <div class="card-body">
                                             <div class="row">
                                                  <div class="col-lg-6">
                                                       <input type="hidden" name="store_settings" value="1">
                                                       <div class="mb-3">
                                                            <label for="store-name" class="form-label">Store Name</label>
                                                            <input type="text" id="store-name" name="store_name" class="form-control" placeholder="Enter name" value="<?= htmlspecialchars($settings['store_name'] ?? '') ?>">
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="owner-name" class="form-label">Store Owner Full Name</label>
                                                            <input type="text" id="owner-name" name="owner_name" class="form-control" placeholder="Full name" value="<?= htmlspecialchars($settings['owner_name'] ?? '') ?>">
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="schedule-number" class="form-label">Owner Phone number</label>
                                                            <input type="number" id="schedule-number" name="owner_phone" class="form-control" placeholder="Number" value="<?= htmlspecialchars($settings['owner_phone'] ?? '') ?>">
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="schedule-email" class="form-label">Owner Email</label>
                                                            <input type="email" id="schedule-email" name="owner_email" class="form-control" placeholder="Email" value="<?= htmlspecialchars($settings['owner_email'] ?? '') ?>">
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-12">
                                                       <div class="mb-3">
                                                            <label for="address" class="form-label">Full Address</label>
                                                            <textarea class="form-control bg-light-subtle" id="address" name="address" rows="3" placeholder="Type address"><?= htmlspecialchars($settings['store_address'] ?? '') ?></textarea>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-4">
                                                       <div class="mb-3">
                                                            <label for="your-zipcode" class="form-label">Zip-Code</label>
                                                            <input type="number" id="your-zipcode" name="zipcode" class="form-control" placeholder="zip-code" value="<?= htmlspecialchars($settings['zipcode'] ?? '') ?>">
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-4">
                                                       <div class="mb-3">
                                                            <label for="choices-city" class="form-label">City</label>
                                                            <select class="form-control" id="choices-city" name="city" data-choices data-choices-groups data-placeholder="Select City">
                                                                 <option value="">Choose a city</option>
                                                                 <optgroup label="UK">
                                                                      <option value="London" <?= $settings['city'] == 'London' ? 'selected' : '' ?>>London</option>
                                                                      <option value="Manchester" <?= $settings['city'] == 'Manchester' ? 'selected' : '' ?>>Manchester</option>
                                                                      <option value="Liverpool" <?= $settings['city'] == 'Liverpool' ? 'selected' : '' ?>>Liverpool</option>
                                                                 </optgroup>
                                                                 <optgroup label="FR">
                                                                      <option value="Paris" <?= $settings['city'] == 'Paris' ? 'selected' : '' ?>>Paris</option>
                                                                      <option value="Lyon" <?= $settings['city'] == 'Lyon' ? 'selected' : '' ?>>Lyon</option>
                                                                      <option value="Marseille" <?= $settings['city'] == 'Marseille' ? 'selected' : '' ?>>Marseille</option>
                                                                 </optgroup>
                                                                 <optgroup label="DE" disabled>
                                                                      <option value="Hamburg" <?= $settings['city'] == 'Hamburg' ? 'selected' : '' ?>>Hamburg</option>
                                                                      <option value="Munich" <?= $settings['city'] == 'Munich' ? 'selected' : '' ?>>Munich</option>
                                                                      <option value="Berlin" <?= $settings['city'] == 'Berlin' ? 'selected' : '' ?>>Berlin</option>
                                                                 </optgroup>
                                                                 <optgroup label="US">
                                                                      <option value="New York" <?= $settings['city'] == 'New York' ? 'selected' : '' ?>>New York</option>
                                                                      <option value="Washington" <?= $settings['city'] == 'Washington' ? 'selected' : '' ?> disabled>Washington</option>
                                                                      <option value="Michigan" <?= $settings['city'] == 'Michigan' ? 'selected' : '' ?>>Michigan</option>
                                                                 </optgroup>
                                                                 <optgroup label="SP">
                                                                      <option value="Madrid" <?= $settings['city'] == 'Madrid' ? 'selected' : '' ?>>Madrid</option>
                                                                      <option value="Barcelona" <?= $settings['city'] == 'Barcelona' ? 'selected' : '' ?>>Barcelona</option>
                                                                      <option value="Malaga" <?= $settings['city'] == 'Malaga' ? 'selected' : '' ?>>Malaga</option>
                                                                 </optgroup>
                                                                 <optgroup label="CA">
                                                                      <option value="Montreal" <?= $settings['city'] == 'Montreal' ? 'selected' : '' ?>>Montreal</option>
                                                                      <option value="Toronto" <?= $settings['city'] == 'Toronto' ? 'selected' : '' ?>>Toronto</option>
                                                                      <option value="Vancouver" <?= $settings['city'] == 'Vancouver' ? 'selected' : '' ?>>Vancouver</option>
                                                                 </optgroup>
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-4">
                                                       <div class="">
                                                            <label for="choices-country" class="form-label">Country</label>
                                                            <select class="form-control" id="choices-country" name="country" data-choices data-choices-groups data-placeholder="Select Country">
                                                                 <option value="">Choose a country</option>
                                                                 <optgroup label="">
                                                                      <option value="United Kingdom" <?= $settings['country'] == 'United Kingdom' ? 'selected' : '' ?>>United Kingdom</option>
                                                                      <option value="France" <?= $settings['country'] == 'France' ? 'selected' : '' ?>>France</option>
                                                                      <option value="Netherlands" <?= $settings['country'] == 'Netherlands' ? 'selected' : '' ?>>Netherlands</option>
                                                                      <option value="U.S.A" <?= $settings['country'] == 'U.S.A' ? 'selected' : '' ?>>U.S.A</option>
                                                                      <option value="Denmark" <?= $settings['country'] == 'Denmark' ? 'selected' : '' ?>>Denmark</option>
                                                                      <option value="Canada" <?= $settings['country'] == 'Canada' ? 'selected' : '' ?>>Canada</option>
                                                                      <option value="Australia" <?= $settings['country'] == 'Australia' ? 'selected' : '' ?>>Australia</option>
                                                                      <option value="India" <?= $settings['country'] == 'India' ? 'selected' : '' ?>>India</option>
                                                                      <option value="Germany" <?= $settings['country'] == 'Germany' ? 'selected' : '' ?>>Germany</option>
                                                                      <option value="Spain" <?= $settings['country'] == 'Spain' ? 'selected' : '' ?>>Spain</option>
                                                                      <option value="United Arab Emirates" <?= $settings['country'] == 'United Arab Emirates' ? 'selected' : '' ?>>United Arab Emirates</option>
                                                                 </optgroup>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div class="col-lg-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h4 class="card-title d-flex align-items-center gap-1"><iconify-icon icon="solar:compass-bold-duotone" class="text-primary fs-20"></iconify-icon>Localization Settings</h4>
                                        </div>
                                        <div class="card-body">
                                             <div class="row">
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="choices-country1" class="form-label">Country</label>
                                                            <select class="form-control" id="choices-country1" data-choices data-choices-groups data-placeholder="Select Country" name="choices-country">
                                                                 <option value="">Choose a country</option>
                                                                 <optgroup label="">
                                                                      <option value="">United Kingdom</option>
                                                                      <option value="Fran">France</option>
                                                                      <option value="Netherlands">Netherlands</option>
                                                                      <option value="U.S.A">U.S.A</option>
                                                                      <option value="Denmark">Denmark</option>
                                                                      <option value="Canada">Canada</option>
                                                                      <option value="Australia">Australia</option>
                                                                      <option value="India">India</option>
                                                                      <option value="Germany">Germany</option>
                                                                      <option value="Spain">Spain</option>
                                                                      <option value="United Arab Emirates">United Arab Emirates</option>
                                                                 </optgroup>
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="choices-language" class="form-label">Language</label>
                                                            <select class="form-control" id="choices-language" data-choices data-choices-groups data-placeholder="Select language" name="choices-language">
                                                                 <option value="">English</option>
                                                                 <optgroup label="">
                                                                      <option value="">Russian</option>
                                                                      <option value="Arabic">Arabic</option>
                                                                      <option value="Spanish">Spanish</option>
                                                                      <option value="Turkish">Turkish</option>
                                                                      <option value="German">German</option>
                                                                      <option value="Armenian">Armenian</option>
                                                                      <option value="Italian">Italian</option>
                                                                      <option value="Catalán">Catalán</option>
                                                                      <option value="Hindi">Hindi</option>
                                                                      <option value="Japanese">Japanese</option>
                                                                      <option value="French">French</option>
                                                                 </optgroup>
                                                            </select>

                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="choices-currency" class="form-label">Currency</label>
                                                            <select class="form-control" id="choices-currency" data-choices data-choices-groups data-placeholder="Select Currency" name="choices-currency">
                                                                 <option value="">Us Dollar</option>
                                                                 <optgroup label="">
                                                                      <option value="">Pound</option>
                                                                      <option value="Indian Rupee">Indian Rupee</option>
                                                                      <option value="Euro">Euro</option>
                                                                      <option value="Australian Dollar">Australian Dollar</option>
                                                                      <option value="Japanese Yen">Japanese Yen</option>
                                                                      <option value="Korean Won">Korean Won</option>
                                                                 </optgroup>
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="mb-3">
                                                            <label for="choices-length" class="form-label">Length Class</label>
                                                            <select class="form-control" id="choices-length" data-choices data-choices-groups data-placeholder="Select Length" name="choices-length">
                                                                 <option value="">Centimeter</option>
                                                                 <optgroup label="">
                                                                      <option value="">Millimeter</option>
                                                                      <option value="Inch">Inch</option>
                                                                 </optgroup>
                                                            </select>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-6">
                                                       <div class="">
                                                            <label for="choices-weight" class="form-label">Weight Class</label>
                                                            <select class="form-control" id="choices-weight" data-choices data-choices-groups data-placeholder="Select Weight" name="choices-weight">
                                                                 <option value="">Kilogram</option>
                                                                 <optgroup label="">
                                                                      <option value="">Gram</option>
                                                                      <option value="Pound">Pound</option>
                                                                      <option value="Ounce">Ounce</option>
                                                                 </optgroup>
                                                            </select>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div class="col-lg-3">
                                   <div class="card">
                                        <div class="card-header">
                                             <h4 class="card-title d-flex align-items-center gap-1"><iconify-icon icon="solar:box-bold-duotone" class="text-primary fs-20"></iconify-icon>Categories Settings</h4>
                                        </div>
                                        <div class="card-body">
                                             <p>Category Product Count </p>
                                             <div class="d-flex gap-2 align-items-center mb-3">
                                                  <div class="form-check">
                                                       <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                                       <label class="form-check-label" for="flexRadioDefault1">
                                                            Yes
                                                       </label>
                                                  </div>
                                                  <div class="form-check">
                                                       <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                       <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                       </label>
                                                  </div>
                                             </div>
                                             <div class="mb-1 pb-1">
                                                  <label for="items-par-page" class="form-label">Default Items Per Page</label>
                                                  <input type="number" id="items-par-page" class="form-control" placeholder="000">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="card">
                                        <div class="card-header">
                                             <h4 class="card-title d-flex align-items-center gap-1"><iconify-icon icon="solar:chat-square-check-bold-duotone" class="text-primary fs-20"></iconify-icon>Reviews Settings</h4>
                                        </div>
                                        <div class="card-body">
                                             <p>Allow Reviews </p>
                                             <div class="d-flex gap-2 align-items-center mb-3">
                                                  <div class="form-check">
                                                       <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault3" checked>
                                                       <label class="form-check-label" for="flexRadioDefault3">
                                                            Yes
                                                       </label>
                                                  </div>
                                                  <div class="form-check">
                                                       <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault4">
                                                       <label class="form-check-label" for="flexRadioDefault4">
                                                            No
                                                       </label>
                                                  </div>
                                             </div>
                                             <p class="mt-3 pt-1">Allow Guest Reviews </p>
                                             <div class="d-flex gap-2 align-items-center mb-2">
                                                  <div class="form-check">
                                                       <input class="form-check-input" type="radio" name="flexRadioDefault3" id="flexRadioDefault5">
                                                       <label class="form-check-label" for="flexRadioDefault5">
                                                            Yes
                                                       </label>
                                                  </div>
                                                  <div class="form-check">
                                                       <input class="form-check-input" type="radio" name="flexRadioDefault3" id="flexRadioDefault6" checked>
                                                       <label class="form-check-label" for="flexRadioDefault6">
                                                            No
                                                       </label>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="card">
                                        <div class="card-header">
                                             <h4 class="card-title d-flex align-items-center gap-1"><iconify-icon icon="solar:ticket-bold-duotone" class="text-primary fs-20"></iconify-icon>Vouchers Settings</h4>
                                        </div>
                                        <div class="card-body">
                                             <div class="mb-3">
                                                  <label for="min-vouchers" class="form-label">Minimum Vouchers</label>
                                                  <input type="number" id="min-vouchers" class="form-control" placeholder="000" value="1">
                                             </div>
                                             <div class="">
                                                  <label for="mex-vouchers" class="form-label">Maximum Vouchers</label>
                                                  <input type="number" id="mex-vouchers" class="form-control" placeholder="000" value="12">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="col-lg-3">
                                   <div class="card">
                                        <div class="card-header">
                                             <h4 class="card-title d-flex align-items-center gap-1"><iconify-icon icon="solar:ticket-sale-bold-duotone" class="text-primary fs-20"></iconify-icon>Tax Settings</h4>
                                        </div>
                                        <div class="card-body">
                                             <p>Prices with Tax</p>
                                             <div class="d-flex gap-2 align-items-center mb-3">
                                                  <div class="form-check">
                                                       <input class="form-check-input" type="radio" name="flexRadioDefault4" id="flexRadioDefault7" checked>
                                                       <label class="form-check-label" for="flexRadioDefault7">
                                                            Yes
                                                       </label>
                                                  </div>
                                                  <div class="form-check">
                                                       <input class="form-check-input" type="radio" name="flexRadioDefault4" id="flexRadioDefault8">
                                                       <label class="form-check-label" for="flexRadioDefault8">
                                                            No
                                                       </label>
                                                  </div>
                                             </div>
                                             <div class="mb-1 pb-1">
                                                  <label for="items-tax" class="form-label">Default Tax Rate</label>
                                                  <input type="text" id="items-tax" class="form-control" placeholder="000" value="18%">
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="row">
                              <div class="col-lg-12">
                                   <div class="card">
                                        <div class="card-header">
                                             <h4 class="card-title d-flex align-items-center gap-1"><iconify-icon icon="solar:users-group-two-rounded-bold-duotone" class="text-primary fs-20"></iconify-icon>Customers Settings</h4>
                                        </div>
                                        <div class="card-body">
                                             <div class="row justify-content-between g-3">
                                                  <div class="col-lg-2 border-end">
                                                       <p>Customers Online</p>
                                                       <div class="d-flex gap-2 align-items-center">
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault5" id="flexRadioDefault9" checked="">
                                                                 <label class="form-check-label" for="flexRadioDefault9">
                                                                      Yes
                                                                 </label>
                                                            </div>
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault5" id="flexRadioDefault10">
                                                                 <label class="form-check-label" for="flexRadioDefault10">
                                                                      No
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-2 border-end">
                                                       <p>Customers Activity</p>
                                                       <div class="d-flex gap-2 align-items-center">
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault6" id="flexRadioDefault11" checked="">
                                                                 <label class="form-check-label" for="flexRadioDefault11">
                                                                      Yes
                                                                 </label>
                                                            </div>
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault6" id="flexRadioDefault12">
                                                                 <label class="form-check-label" for="flexRadioDefault12">
                                                                      No
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-2 border-end">
                                                       <p>Customer Searches</p>
                                                       <div class="d-flex gap-2 align-items-center">
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault7" id="flexRadioDefault13" checked="">
                                                                 <label class="form-check-label" for="flexRadioDefault13">
                                                                      Yes
                                                                 </label>
                                                            </div>
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault7" id="flexRadioDefault14">
                                                                 <label class="form-check-label" for="flexRadioDefault14">
                                                                      No
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-2 border-end">
                                                       <p>Allow Guest Checkout</p>
                                                       <div class="d-flex gap-2 align-items-center">
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault8" id="flexRadioDefault15">
                                                                 <label class="form-check-label" for="flexRadioDefault15">
                                                                      Yes
                                                                 </label>
                                                            </div>
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault8" id="flexRadioDefault16" checked="">
                                                                 <label class="form-check-label" for="flexRadioDefault16">
                                                                      No
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-lg-2">
                                                       <p>Login Display Price</p>
                                                       <div class="d-flex gap-2 align-items-center">
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault9" id="flexRadioDefault17">
                                                                 <label class="form-check-label" for="flexRadioDefault17">
                                                                      Yes
                                                                 </label>
                                                            </div>
                                                            <div class="form-check">
                                                                 <input class="form-check-input" type="radio" name="flexRadioDefault9" id="flexRadioDefault18" checked="">
                                                                 <label class="form-check-label" for="flexRadioDefault18">
                                                                      No
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="row mt-3">
                                                  <div class="col-lg-6">
                                                       <div class="">
                                                            <label for="login-attempts" class="form-label">Max Login Attempts</label>
                                                            <input type="text" id="login-attempts" class="form-control" placeholder="max" value="1 hour">
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <div class="text-end">
                              <button type="button" class="btn btn-danger" onclick="resetForm()">Cancel</button>
                              <button type="submit" class="btn btn-success">Save Changes</button>
                         </div>
                    </form>
               </div>
               <!-- End Container Fluid -->

          <!-- ========== Footer Start ========== -->
          <?php include 'includes/footer.php'; ?>
          <!-- ========== Footer End ========== -->

          </div>
          <!-- ==================================================== -->
          <!-- End Page Content -->
          <!-- ==================================================== -->


     </div>
     <!-- END Wrapper -->

     <!-- Vendor Javascript (Require in all Page) -->
     <script src="assets/js/vendor.js"></script>

     <!-- App Javascript (Require in all Page) -->
     <script src="assets/js/app.js"></script>

     <script>
     function resetForm() {
          document.getElementById('settingsForm').reset();
     }

     // Add any other JavaScript functionality you need
     </script>

</body>

</html>