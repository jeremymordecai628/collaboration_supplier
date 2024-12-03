```mermaid
graph TD
    Supplier --> register[[Register]]
    register --> SupplierData[(Supplier Data)]
    SupplierData -->|checks for Supplier credetials| SignIn((Sign In))
    SupplierData -->|Send data  for Evaluation| ProcurementOfficer
    ProcurementOfficer -->|Place Orders| SendsOrder
    SendsOrder --> Supplier
    ProcurementOfficer --> organize[[Organization Register]]
    Technician --> organize
    User --> organize
    organize --> OrganizationDomain[/organizational domain/]
    OrganizationDomain --> orgines[(Organization Data)]
    orgines --> |checks for  Organization members credetials|SignIn
    User -->|Raise Request| Technician
    Technician -->|Sends Request for approval| ProcurementOfficer
    Supplier -->|Delivers order| Technician
    Technician -->|Delivers to User| User
    Technician -->|Rates and stores the Supplier services| SupplierData
    Supplier -->|input the  products their have| ProductData[(Product Data)]
    ProductData -->|Checking if product is Available  before ordering| ProcurementOfficer
    Technician -->|Notify  of the features they need| Administrator
    Administrator -->|manages Supplier data| SupplierData
    Administrator -->|Ensures organization staff  access  the system through their domain name|OrganizationDomain
    
