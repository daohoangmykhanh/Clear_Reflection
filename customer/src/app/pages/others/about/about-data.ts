interface IconBox {
    adClass: string;
    icon: string;
    title: string;
    title_vi: string;
    content: string;
    content_vi: string;
}

interface Counter {
    limit: number;
    text: string;
    text_vi: string;
    unit?: string;
}

export const iconBoxes: IconBox[] = [
    {
        adClass: "icon-box icon-box-sm text-center",
        icon: "icon-puzzle-piece",
        title: "Design Quality",
        title_vi: "Chất Lượng Thiết Kế ",
        content_vi: "Cửa hàng gương trang điểm của tôi có chất lượng thiết kế tinh tế kết hợp hài hòa giữa vẻ đẹp và tính năng, tạo nên trải nghiệm mua sắm đáng say mê cho khách hàng.",
        content: "My sale mirror store boasts a design quality that seamlessly blends elegance and functionality, creating an enchanting shopping experience for customers.e."
    },
    {
        adClass: "icon-box icon-box-sm text-center",
        icon: "icon-life-ring",
        title: "Professional Support",
        title_vi: "Hỗ Trợ Chuyên Nghiệp.",
        content_vi: "Đội ngũ hỗ trợ chuyên nghiệp của chúng tôi cam kết cung cấp sự trợ giúp tuyệt vời, đảm bảo mọi nhu cầu và quan tâm của bạn được giải quyết một cách nhanh chóng với sự chuyên môn và tận tâm tối đa.",
        content: "Our professional support team is dedicated to providing exceptional assistance, ensuring that all your needs and concerns are promptly addressed with the utmost expertise and care. "
    },
    {
        adClass: "icon-box icon-box-sm text-center",
        icon: "icon-heart-o",
        title: "Made With Love",
        title_vi: "Được làm từ tình yêu.",
        content_vi: "Mỗi sản phẩm trong cửa hàng của chúng tôi đều được chế tác tỉ mỉ bằng tình yêu, đảm bảo rằng mọi chi tiết đều phản ánh niềm đam mê và sự cống hiến của chúng tôi trong việc mang đến chất lượng vượt trội cho khách hàng.",
        content: "Every product in our store is meticulously crafted with love, ensuring that every detail reflects our passion and dedication to delivering exceptional quality to our customers."
    }
]

export const counters: Counter[] = [
    {
        limit: 40,
        text: "Happy Customers",
        text_vi: "Khách Hàng Hài Lòng",
        unit: "k+"
    },
    {
        limit: 20,
        text: "Years in Business",
        text_vi: "Số Năm Kinh Doanh",
        unit: "+"
    },
    {
        limit: 95,
        text: "Return Clients",
        text_vi: "Khách Hàng Quay Lại",
        unit: "%"
    }
]
