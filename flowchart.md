```mermaid

graph TD;
    Start((Start)) --> Creation_of_purchase_request[Creation of Purchase Request];
    Creation_of_purchase_request --> Save_purchase_request{{Save Purchase Request}};
    Save_purchase_request --> Send_request_for_approval[Send Request for Approval];
    Send_request_for_approval --> Is_It_Approved{Is It Approved?};
    Is_It_Approved -->|Yes| Update_Saved_purchase_request{{Update Saved Purchase Request}};
    Is_It_Approved -->|No| Stop((Stop));
    Update_Saved_purchase_request -->Creation_of_Purchase_Order;
    Creation_of_Purchase_Order -->Send_purchase_order_for_approval;
    Send_purchase_order_for_approval --> If_purchase_order_approved{If_purchase_order_approved};
    If_purchase_order_approved --> |yes| Send_order;
    Notification --> Vendor_Rating[Vendor Rating];
    Vendor_Rating --> Vendor_Point[Vendor Point];
    Vendor_Point --> Finish;
